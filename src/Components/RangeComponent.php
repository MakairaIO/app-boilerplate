<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('range')]
class RangeComponent
{
    public function __construct()
    {
        $this->id = bin2hex(random_bytes(16));
    }
    public string $id;
    public string $name = 'range_name';
    public string $title = 'Title';
    public int $minValue = 0;
    public int $maxValue = 10;
    public int $value = 3;
    public bool $showNumber = true;
}