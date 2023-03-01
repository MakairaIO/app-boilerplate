<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('tabs')]
class TabsComponent
{
    public function __construct()
    {
        $this->groupKey = bin2hex(random_bytes(16));
    }

    public string $groupKey;

    public array $tabs = [];
}

class TabContent {
    public string $title;
    public string $key;
    public bool $selected;
    public bool $disabled;
    public string $content;
    public string $contentType; // text, html
}