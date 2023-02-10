<?php
// src/Components/ButtonComponent.php
namespace App\Components;

use phpDocumentor\Reflection\Types\Boolean;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('button')]
class ButtonComponent
{
  public string $children = '';
  public string $href = '';
  public bool $isExternalLink = false;
  public bool $disabled = false;
  public string $icon = '';
  public string $buttonClasses = 'button';

  public function mount(string $variant = 'primary', string $icon = '')
  {
    $this->buttonClasses = $this->buttonClasses . " button--{$variant}";

    if ($icon != '') {
      $this->buttonClasses = $this->buttonClasses . " button--icon button--icon-right";
      $this->icon = $icon;
    }
  }
}