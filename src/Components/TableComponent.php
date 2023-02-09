<?php

namespace App\Components;

use phpDocumentor\Reflection\Types\Boolean;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('table')]
class TableComponent
{
  public array $columns =  [];
  public array $rows = [];
  // public array $columns =  [
  //   ['title' => 'Column 1', 'component' => ''],
  //   ['title' => 'Column 2', 'component' => ''],
  //   ['title' => 'Column 3', 'component' => ''],
  //   ['title' => 'Column 4', 'component' => 'component'],
  // ];

  // public array $rows = [
  //   ['row1 - col1', 'row1 - col2', 'row1 - col3', ['component' => 'button', 'variant' => 'primary', 'children' => 'Primary', 'loading' => true, 'disabled' => false, 'icon' => 'star']],
  //   ['row2 - col1', 'row2 - col2', 'row2 - col3', ['component' => 'button', 'variant' => 'primary', 'children' => 'Primary', 'loading' => true, 'disabled' => false, 'icon' => 'star']],
  //   ['row3 - col1', 'row3 - col2', 'row3 - col3', ['component' => 'button', 'variant' => 'secondary', 'children' => 'Click me', 'loading' => false, 'disabled' => false, 'icon' => '']],
  //   ['row4 - col1', 'row4 - col2', 'row4 - col3', ['component' => 'textarea', 'name' => 'area_demo', 'placeholder' => 'placeholder', 'title' => 'title',]],
  //   ['row5 - col1', 'row5 - col2', ],
  // ];
}