<?php
    namespace App\Components;

    use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

    #[AsTwigComponent('radio')]
    class RadioComponent
    {
        public string $name = 'radio_name';
        public string $size = 'medium'; // medium, large
        public bool $disabled = false;

        public array $options = array(
            array('label' => 'Banana', 'value' => 'Banana'),
            array('label' => 'Pineapple', 'value' => 'Pineapple'),
            array('label' => 'Avocado', 'value' => 'Avocado'),
            array('label' => 'Potato', 'value' => 'Potato'),
            array('label' => 'Tomato', 'value' => 'Tomato')
        );

    }