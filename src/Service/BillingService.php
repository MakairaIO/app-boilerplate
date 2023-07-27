<?php

namespace App\Service;

use App\Entity\AppInfo;
use App\Repository\AppInfoRepository;
use App\Traits\RetryExecutorTrait;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Notifier\ChatterInterface;
use Symfony\Component\Notifier\Message\ChatMessage;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class BillingService
{
    use RetryExecutorTrait;

    public function __construct(
        private readonly string            $creditChargeUrl,
        private readonly string            $appUrl,
        private readonly string            $billingToken,
        private readonly string            $appName,
        private readonly AppInfoRepository $appInfoRepository,
        private readonly ChatterInterface  $chatter
    )
    {
    }

    /**
     * this is the public function you can call to bill customers
     * you can customize the appInfos that are being loaded aswell as the credits you want to bill
     *
     * @return void
     * @throws \Symfony\Component\Notifier\Exception\TransportExceptionInterface
     * @throws \Throwable
     */
    public function billCustomers(): void
    {
        $appInfos = $this->appInfoRepository->findAll(); //change this to load only the appInfos (customers) you want to charge
        $creditsToBill = 1; //change this to the amount you want to charge

        foreach ($appInfos as $appInfo) {
            try {
                $this->retry(
                    function () use ($appInfo, $creditsToBill) {
                        $this->sendBillingRequest($appInfo, $creditsToBill);
                    },
                    [],
                    3,
                    3);
            } catch (\Exception $exception) {

                $message = (new ChatMessage(
                    sprintf(
                        '%s: Error billing customer %s. More info to find here: %s',
                        $this->appName,
                        $appInfo->getMakairaDomain(),
                        $exception->getMessage()
                    )
                ))->transport('slack');

                $this->chatter->send($message);
            }
        }
    }

    /**
     * sends the request to makairas billing api
     *
     * @param AppInfo $appInfo
     * @param int $amount
     * @return void
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    private function sendBillingRequest(AppInfo $appInfo, int $amount): void
    {
        $client = HttpClient::create();
        $chargeMessage = sprintf('Charge from %s', $this->appName);
        $response = $client->request(
            'POST',
            $this->creditChargeUrl,
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'APP-SIGNATURE-TOKEN' => $this->getBillingToken(),
                ],
                'json' => [
                    'domain' => $appInfo->getMakairaDomain(),
                    'appUrl' => $this->appUrl,
                    'instance' => $appInfo->getMakairaInstance(),
                    'credit' => $amount,
                    'activityName' => $chargeMessage,
                    'activityDescription' => $chargeMessage,
                ]
            ]
        );
        $content = json_decode($response->getContent(), true);
        $header = $response->getHeaders();

        if (
            $response->getStatusCode() !== 200 ||
            !isset($content['status']) ||
            $content['status'] !== 'success'
        ) {
            throw new \Exception($header['x-debug-token-link'][0]);
        }
    }

    /**
     * generates the billing token for the request
     *
     * @return string
     */
    private function getBillingToken(): string
    {
        $hmac = hash_hmac(
            'sha256',
            $this->appUrl,
            $this->billingToken
        );

        $data = [
            'appUrl' => $this->appUrl,
            'hmac' => $hmac
        ];

        return base64_encode(json_encode($data));
    }
}
