<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('modal')]
class ModalComponent
{
    public function __construct()
    {
        $this->id = bin2hex(random_bytes(16));
    }

    public string $id = '';
    public string $title = '';
    public string $content = '';
    public string $footer = '';
}
