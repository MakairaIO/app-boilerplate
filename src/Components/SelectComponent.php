<?php
    namespace App\Components;

    use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

    #[AsTwigComponent('select')]
    class SelectComponent
    {
        public string $name = 'select_name';
        public string $title = 'title';
        public string $placeholder = 'placeholder';
        public bool $disabled = false;
        public bool $borderless = false;
        public array $options = array(
            array('label' => 'Banana', 'value' => 'Banana'),
            array('label' => 'Pineapple', 'value' => 'Pineapple'),
            array('label' => 'Avocado', 'value' => 'Avocado'),
            array('label' => 'Potato', 'value' => 'Potato'),
            array('label' => 'Tomato', 'value' => 'Tomato')
        );

    }