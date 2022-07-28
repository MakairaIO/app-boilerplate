<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'app_app')]
    public function index(Request $request): Response
    {
        $domain = $request->query->get("domain");
        $instance = $request->query->get("instance");

        return $this->render('app/index.html.twig', [
            'domain' => $domain,
            'instance' => $instance
        ]);
    }

    #[Route('/example', name: 'app_example')]
    public function example(Request $request): Response
    {
        $domain = $request->query->get("domain");
        $instance = $request->query->get("instance");

        return $this->render('app/example.html.twig', [
            'domain' => $domain,
            'instance' => $instance
        ]);
    }
}
