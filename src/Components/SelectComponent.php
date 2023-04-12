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
    public string $selectedValue = '';
    public string $customLabel = '';
    public string $customInput = '';
    public array $options = [
        ['label' => 'Banana', 'value' => 'Banana'],
        ['label' => 'Pineapple', 'value' => 'Pineapple'],
        ['label' => 'Avocado', 'value' => 'Avocado'],
        ['label' => 'Potato', 'value' => 'Potato'],
        ['label' => 'Tomato', 'value' => 'Tomato'],
    ];

}