<?php

namespace App\Service;

use Exception;
use App\Entity\AppInfo;
use App\Repository\AppInfoRepository;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class CommunicationService
{
    private string $nonce;
    private AppInfoRepository $appInfoRepository;

    /**
     * @throws Exception
     */
    public function __construct(AppInfoRepository $appInfoRepository)
    {
        $this->nonce = bin2hex(random_bytes(16));
        $this->appInfoRepository = $appInfoRepository;
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
        $appInfo = $this->appInfoRepository->findOneByDomainAndInstance($domain, $instance);
        $appSecret = $appInfo ? $appInfo->getAppSecret() : '';

        return hash_hmac(
            'sha256',
            sprintf('%s:%s:%s:%s', $this->getNonce(), $domain, $instance, $makairaHmac),
            $appSecret
        );
    }

    /**
     * @return string
     */
    public function getNonce(): string
    {
        return $this->nonce;
    }
}