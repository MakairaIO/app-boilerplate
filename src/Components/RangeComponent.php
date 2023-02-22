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
    public int $defaultValue = 3;
    public int $maxValue = 10;
    public int $step = 1;
    public bool $showNumber = true;
    public string $title = 'Title';
}