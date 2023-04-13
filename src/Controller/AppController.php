<?php

namespace App\Controller;

use App\Service\CommunicationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    public function __construct(private readonly CommunicationService $communicationService)
    {
    }

    #[Route('/request', name: 'app_request', methods: ['POST'])]
    public function request(Request $request, MailerInterface $mailer): Response
    {
        $recipient = $_ENV['MAILER_RECIPIENT'];
        $email     = $request->request->get('email');
        $name      = $request->request->get('name');
        $message   = trim($request->request->get('message'));
        $feedUrl   = $request->request->get('feed');
        $domain    = $request->query->get("domain") ?? '';

        $body = "
Neue Anfrage von: $name (Domain: $domain).

Email: $email

Feed: $feedUrl

Nachricht:
$message
";

        $body = trim($body);

        try {
            $email = (new Email())->from('quickstart@makaira.io')
                ->to($recipient)
                ->subject('Makaira Quickstart - Neue Anfrage')
                ->text($body);

            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            // TODO: Handle exception - maybe log it?
            return $this->render('app/index.html.twig', [
                'state' => 'There was an error sending your request. Please try again later or contact hello@makaira.io directly..',
            ]);
        }

        return $this->render('app/index.html.twig', [
            'state' => 'Thank you for your request. We will get back to you as soon as possible.',
        ]);
    }

    #[Route('/', name: 'app_app')]
    public function index(Request $request): Response
    {
        $domain      = $request->query->get("domain") ?? '';
        $instance    = $request->query->get("instance") ?? '';
        $makairaHmac = $request->query->get("hmac") ?? '';

        $nonce = $this->communicationService->getNonce();
        $hmac  = $this->communicationService->getHMAC($instance, $domain, $makairaHmac);

        return $this->render('app/index.html.twig', [
            'state' => '',
        ]);
    }

    #[Route('/example', name: 'app_example')]
    public function example(Request $request): Response
    {
        $domain      = $request->query->get("domain") ?? '';
        $instance    = $request->query->get("instance") ?? '';
        $makairaHmac = $request->query->get("hmac") ?? '';

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
        $listData = [
            [
                "id"         => 12,
                "identifier" => "fancy-teaser",
                "name"       => "Fancy Teaser",
            ],
            [
                "id"         => 12,
                "identifier" => "contact-form",
                "name"       => "Contact Form",
            ],
            [
                "id"         => 8,
                "identifier" => "teaser-grid",
                "name"       => "Teaser (Grid)",
            ],
        ];

        return $this->render('app/story.html.twig', [
            'listData' => $listData,
        ]);
    }

    #[Route('/component-list', name: 'component_list')]
    public function componentList(Request $request): Response
    {
        $components = $this->communicationService->fetchComponents();

        return $this->render('app/component-list.html.twig', [
            'components' => $components,
        ]);
    }

    #[Route('/content-widget', name: 'content_widget')]
    public function contentWidget(Request $request): Response
    {
        $domain      = $request->query->get("domain");
        $instance    = $request->query->get("instance");
        $makairaHmac = $request->query->get("hmac");

        $pageId    = $request->query->get("pageId");
        $pageType  = $request->query->get("pageType");
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
            'pageTitle'   => $pageTitle,
        ]);
    }
}
