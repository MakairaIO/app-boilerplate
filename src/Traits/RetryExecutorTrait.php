<?php

namespace App\Traits;

use Closure;
use Throwable;

trait RetryExecutorTrait
{
    private function retry(
        Closure $closure,
        array $args = [],
        int $maxRetries = 3,
        int $retryDelay = 1
    ) {
        $try = 0;
        while (true) {
            try {
                return $closure(...$args);
            } catch (Throwable $t) {
                if ($try === $maxRetries) {
                    throw $t;
                }
                ++$try;
                sleep($retryDelay);
            }
        }
    }
}
