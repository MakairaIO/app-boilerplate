<?php

namespace App\Service;

use Exception;

class CommunicationService
{
    private string $nonce;

    /**
     * @throws Exception
     */
    public function __construct(private readonly string $userSecret)
    {
        $this->nonce = bin2hex(random_bytes(16));
    }

    /**
     * Get the HMAC that than can be sent to Makaira Backend to be validated
     * and to retrieve the AuthToken.
     *
     * @param $instance
     * @param $domain
     * @return string
     */
    public function getHMAC($instance, $domain): string
    {
        return hash_hmac(
            'sha256',
            sprintf('%s:%s:%s', $this->getNonce(), $domain, $instance),
            $this->userSecret
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