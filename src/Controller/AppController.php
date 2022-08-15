<?php

namespace App\Controller;

use App\Service\CommunicationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    public function __construct(private readonly CommunicationService $communicationService)
    {
    }

    #[Route('/', name: 'app_app')]
    public function index(Request $request): Response
    {
        $domain      = $request->query->get("domain");
        $instance    = $request->query->get("instance");
        $makairaHmac = $request->query->get("hmac");

        $nonce = $this->communicationService->getNonce();
        $hmac  = $this->communicationService->getHMAC($instance, $domain, $makairaHmac);

        return $this->render('app/index.html.twig', [
            'hmac'        => $hmac,
            'makairaHmac' => $makairaHmac,
            'nonce'       => $nonce,
            'domain'      => $domain,
            'instance'    => $instance,
        ]);
    }

    #[Route('/example', name: 'app_example')]
    public function example(Request $request): Response
    {
        $domain      = $request->query->get("domain");
        $instance    = $request->query->get("instance");
        $makairaHmac = $request->query->get("hmac");

        $nonce = $this->communicationService->getNonce();
        $hmac  = $this->communicationService->getHMAC($instance, $domain, $makairaHmac);

        return $this->render('app/example.html.twig', [
            'hmac'        => $hmac,
            'makairaHmac' => $makairaHmac,
            'nonce'       => $nonce,
            'domain'      => $domain,
            'instance'    => $instance,
        ]);
    }
}
