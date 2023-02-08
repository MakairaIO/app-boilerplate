<?php
    namespace App\Components;

    use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

    #[AsTwigComponent('checkbox')]
    class CheckboxComponent
    {
        public string $name = '';
        public string $label = '';
    }