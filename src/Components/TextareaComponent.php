<?php
    namespace App\Components;

    use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

    #[AsTwigComponent('textarea')]
    class TextareaComponent
    {
        public string $name = '';

        public string $placeholder = '';

        public string $title = '';

        public bool $disabled = false;

        public int $maxlength = 20;

        public string $value = '';

        public string $description = '';

        public string $error = '';

    }