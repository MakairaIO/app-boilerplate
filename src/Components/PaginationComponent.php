<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('pagination')]
class PaginationComponent
{
    public int $totalPages = 1;
    public int $currentPage = 1;
    public string $route = 'app_app';
}