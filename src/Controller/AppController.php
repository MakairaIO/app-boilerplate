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

    #[Route('/story', name: 'app_story')]
    public function story(Request $request): Response
    {
        return $this->render('app/story.html.twig');
    }

    #[Route('/component-list', name: 'component_list')]
    public function componentList(Request $request): Response
    {
        $components = $this->communicationService->fetchComponents();

        $dummyComponents = [
            [
                "id" => 12,
                "identifier" => "contact-form",
                "name" => "Contact Form",
            ],
            [
                "id" => 8,
                "identifier" => "teaser-grid",
                "name" => "Teaser (Grid)",
                "componentData" =>  ['component' => 'button', 'variant' => 'primary', 'children' => 'Example page', 'loading' => false, 'disabled' => false, 'icon' => '', 'href' => '/story']
            ],
        ];
        
        return $this->render('app/component-list.html.twig', [
            'components'  => $components,
            'dummyComponents'  => $dummyComponents,
        ]);
    }

    #[Route('/content-widget', name: 'content_widget')]
    public function contentWidget(Request $request): Response
    {
        $domain      = $request->query->get("domain");
        $instance    = $request->query->get("instance");
        $makairaHmac = $request->query->get("hmac");

        $pageId = $request->query->get("pageId");
        $pageType = $request->query->get("pageType");
        $pageTitle = $request->query->all()['pageTitle'];

        $nonce = $this->communicationService->getNonce();
        $hmac  = $this->communicationService->getHMAC($instance, $domain, $makairaHmac);

        return $this->render('app/content_widget.html.twig', [
            'hmac'        => $hmac,
            'makairaHmac' => $makairaHmac,
            'nonce'       => $nonce,
            'domain'      => $domain,
            'instance'    => $instance,
            'pageId'      => $pageId,
            'pageType'    => $pageType,
            'pageTitle'   => $pageTitle
        ]);
    }
}
