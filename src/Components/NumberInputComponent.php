<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('numberinput')]
class NumberInputComponent
{
    public function __construct()
    {
        $this->id = bin2hex(random_bytes(16));
    }
    public string $id;
    public string $name = 'numinput_name';
    public string $title;
    public int $minValue = 0;
    public int $maxValue = 20;
    public int $value = 5;
    public string $placeholder;
    public bool $disabled = false;
    public string $customLabel = '';
    public string $customInput = '';
}