<?php

namespace App\Service;

use Exception;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\AppInfo;

class CommunicationService
{
    private string $nonce;
    private ManagerRegistry $doctrine;

    /**
     * @throws Exception
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->nonce = bin2hex(random_bytes(16));
        $this->doctrine = $doctrine;
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
        $appInfo = $this->doctrine->getRepository(AppInfo::class)->findOneBySome($domain, $instance);
        return hash_hmac(
            'sha256',
            sprintf('%s:%s:%s:%s', $this->getNonce(), $domain, $instance, $makairaHmac),
            $appInfo->getAppSecret()
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