<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('radio')]
class RadioComponent
{
    public string $name = 'radio_name';
    public string $size = 'medium'; // medium, large
    public bool $disabled = false;

    public array $options = [
        ['label' => 'Banana', 'value' => 'Banana'],
        ['label' => 'Pineapple', 'value' => 'Pineapple'],
        ['label' => 'Avocado', 'value' => 'Avocado'],
        ['label' => 'Potato', 'value' => 'Potato'],
        ['label' => 'Tomato', 'value' => 'Tomato'],
    ];

}