<?php

namespace App\Components;

use phpDocumentor\Reflection\Types\Boolean;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('table')]
class TableComponent
{
  public array $columns =  [];
  public array $data = [];
  public bool $loading = false;
  public string $wrapperClasses = 'mk-table__wrapper';

  public function mount( bool $loading = false)
  {
    if ($loading) {
      $this->wrapperClasses = $this->wrapperClasses . " mk-table__wrapper--loading";
      $this->loading = $loading;
    }
  }
}