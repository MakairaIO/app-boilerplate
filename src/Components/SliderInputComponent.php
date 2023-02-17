<?php
// src/Components/SliderInputComponent.php
namespace App\Components;

use phpDocumentor\Reflection\Types\Boolean;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('slider-input')]
class SliderInputComponent
{
    public string $sliderId = 'slider-input';
    public int $maxValue = 10;
}