<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('page-title')]
class PageTitleComponent
{
    public string $children = 'Willkommen bei Makaira, Jan!';
    public string $prefix = '';
    public string $suffix = '';
}