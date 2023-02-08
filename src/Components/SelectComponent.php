<?php
    namespace App\Components;

    use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

    #[AsTwigComponent('select')]
    class SelectComponent
    {
        public string $name = '';
        
        public string $label = '';
    }