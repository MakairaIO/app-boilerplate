<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('tab-bar')]
class TabBarComponent
{
    public function __construct()
    {
        $this->groupKey = bin2hex(random_bytes(16));
    }

    public string $groupKey;

    public array $tabs = [];
}

class TabBarContent {
    public string $title;
    public bool $selected;
    public string $href;
}