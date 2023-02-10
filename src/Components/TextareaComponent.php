<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('textarea')]
class TextareaComponent
{
    public string $name = 'area_demo';

    public string $placeholder = 'placeholder...';

    public string $title = 'Title';

    public bool $disabled = false;

    public int $maxlength = 20;

    public string $value = '';

    public string $description = 'Textarea description';

    public string $error = '';

}