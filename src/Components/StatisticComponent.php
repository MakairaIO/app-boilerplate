<?php

namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('statistic')]
class StatisticComponent
{
    public string $value = '';
    public string $title = '';
    public string $text = '';
    public string $type = 'primary'; // 'primary' or 'secondary'
    public string $size = 'medium'; // 'small' or 'medium' or 'large'
    public string $status = ''; // 'up' or 'down'
    public string $href = '';
}