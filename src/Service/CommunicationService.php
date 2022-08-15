<?php

namespace App\Service;

use Exception;

class CommunicationService
{
    private string $nonce;

    /**
     * @throws Exception
     */
    public function __construct(private readonly string $clientSecret)
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
}