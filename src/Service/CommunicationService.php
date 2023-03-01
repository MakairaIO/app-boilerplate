<?php

namespace App\Service;

use Exception;
use Makaira\HttpClient;

class CommunicationService
{
    private string $nonce;

    /**
     * @throws Exception
     */
    public function __construct(private readonly string $clientSecret, private readonly HttpClient $httpClient, private readonly string $url, private readonly string $instance)
    {
        $this->nonce = bin2hex(random_bytes(16));
    }

    /**
     * Get the HMAC that than can be sent to Makaira Backend to be validated
     * and to retrieve the AuthToken.
     *
     * @param $instance string Instance that was received from the Makaira-Iframe-URL
     * @param $domain string Domain that was received from the Makaira-Iframe-URL
     * @param $makairaHmac string Hash that was received from the Makaira-Iframe-URL
     * @return string
     */
    public function getHMAC(string $instance, string $domain, string $makairaHmac): string
    {
        return hash_hmac(
            'sha256',
            sprintf('%s:%s:%s:%s', $this->getNonce(), $domain, $instance, $makairaHmac),
            $this->clientSecret
        );
    }

    /**
     * @return string
     */
    public function getNonce(): string
    {
        return $this->nonce;
    }

    /**
     * @return array
     */
    public function fetchComponents(): array {
        $request = "{$this->url}/component/";
        $headers = [
            "X-Makaira-Instance: {$this->instance}",
            "Content-Type: application/json; charset=UTF-8",
        ];

        try {
            $response = $this->httpClient->request('GET', $request, null, $headers);

            if ($response->status !== 200) {
                throw new Exception();
            }

            return json_decode($response->body, true);
        } catch (Exception $e) {
            return [];
        }
    }
}