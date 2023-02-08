<?php
    namespace App\Components;

    use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

    #[AsTwigComponent('checkbox')]
    class CheckboxComponent
    {
        public string $name = 'chk_name';
        public string $label = 'This is checkbox';
        public bool $disabled = false;
    }