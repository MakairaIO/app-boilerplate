<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class SignedRequestAuthenticator extends AbstractAuthenticator {

    private Environment $twig;
    private string $clientSecret;

    public function __construct(Environment $twig, string $clientSecret)
    {
        $this->twig = $twig;
        $this->clientSecret = $clientSecret;
    }

    public function supports(Request $request): ?bool
    {
        return true;
    }

    public function authenticate(Request $request): Passport
    {
        $nonce = $request->query->get("nonce");
        $domain = $request->query->get("domain");
        $instance = $request->query->get("instance");
        $hmac = $request->query->get("hmac");

        if (null === $nonce || null == $domain || null == $instance || null === $hmac) {
            throw new AuthenticationException();
        }

        $expected = hash_hmac(
            'sha256',
            sprintf('%s:%s:%s', $nonce, $domain, $instance),
            $this->clientSecret
        );

        return new Passport(new UserBadge("signed_request"), new CustomCredentials(
           function ($credentials) {
               return $credentials[0] === $credentials[1];
           },
           [$expected, $hmac]
        ));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $response = new Response();
        $response->setStatusCode(401);
        $response->setContent($this->twig->render('error.twig'));

        return $response;
    }
}