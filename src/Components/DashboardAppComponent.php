<?php
    namespace App\Components;

    use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

    #[AsTwigComponent('dashboard-app')]
    class DashboardAppComponent
    {
        public string $icon = 'file-powerpoint';
        public string $text = 'Pages';
        public string $href = '';
        public string $badge = 'New release';

    }