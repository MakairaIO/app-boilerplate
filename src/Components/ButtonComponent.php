<?php
// src/Components/ButtonComponent.php
namespace App\Components;

use phpDocumentor\Reflection\Types\Boolean;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('button')]
class ButtonComponent
{
  // public string $variant = 'primary';
  public string $children = '';
  public bool $loading = false;
  public string $onClick = '';
  public bool $disabled = false;
  public string $icon = '';
  public string $iconPosition = '';

  public string $buttonClasses = 'button';

  public function mount(string $variant = 'primary', string $icon = '', string $iconPosition = 'right', bool $loading = false)
  {
    
    $this->buttonClasses = $this->buttonClasses . " button--{$variant}";

    if ($icon != '') {
      $this->buttonClasses = $this->buttonClasses . " button--icon button--{$this->iconPosition}";
      $this->icon = $icon;

      $this->iconPosition = $iconPosition != '' ? $iconPosition : 'right';
    }

    if ($loading) {
      $this->buttonClasses = $this->buttonClasses . " button--loading";
      $this->loading = $loading;
    }
  }
}