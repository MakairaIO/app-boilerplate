<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('heading')]
class HeadingComponent
{
    public string $children = 'Page heading h2';
    public int $level = 2;
}