<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('textinput')]
class TextInputComponent
{
    public string $name = 'txtinput_name';
    public string $type = 'text';
    public string $title = 'title';
    public string $value = '';
    public string $placeholder = 'input...';
    public bool $required = false;
    public bool $disabled = false;
    public string $customLabel = '';
    public string $customInput = '';
}