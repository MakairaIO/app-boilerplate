<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('numberinput')]
class NumberInputComponent
{
    public string $name = 'numinput_name';
    public string $title;
    public int $minValue = 0;
    public int $maxValue = 20;
    public int $step = 1;
    public int $value = 5;
    public string $placeholder = 'I am a number....';
    public bool $disabled = false;
}