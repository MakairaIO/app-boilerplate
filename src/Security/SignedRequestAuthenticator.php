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

    /**
     * All requests should be handled by this Authenticator.
     *
     * @param Request $request
     * @return bool
     */
    public function supports(Request $request): bool
    {
        return true;
    }

    /**
     * Check if all required query parameters are set and calculate
     * out of the value "nonce:domain:instance" together with the clientSecret
     * the expected HMAC. This hash is than compared to the provided one.
     *
     * @param Request $request
     * @return Passport
     */
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

    /**
     * On a successful authentication we want to do nothing so that the request is
     * simply handled by the corresponding controller.
     *
     * @param Request $request
     * @param TokenInterface $token
     * @param string $firewallName
     * @return Response|null
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    /**
     * On a failed authentication we want to return a rendered error page.
     *
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