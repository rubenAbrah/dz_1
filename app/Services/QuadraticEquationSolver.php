<?php

namespace App\Services;

use InvalidArgumentException;

class QuadraticEquationSolver
{
    public static function solve(float $a, float $b, float $c): array
    {
        $epsilon = 1e-8;

        // Проверка на NaN и INF
        if (is_nan($a) || is_infinite($a) || 
            is_nan($b) || is_infinite($b) || 
            is_nan($c) || is_infinite($c)) {
            throw new InvalidArgumentException('All coefficients must be finite and non-NaN.');
        }

        // Проверка, что a не ноль
        if (abs($a) < $epsilon) {
            throw new InvalidArgumentException('Coefficient a cannot be zero.');
        }

        $discriminant = $b * $b - 4 * $a * $c;

        if ($discriminant < -$epsilon) {
            return [];
        } elseif (abs($discriminant) < $epsilon) {
            $x = -$b / (2 * $a);
            return [$x, $x];
        } else {
            $sqrtD = sqrt($discriminant);
            $x1 = (-$b + $sqrtD) / (2 * $a);
            $x2 = (-$b - $sqrtD) / (2 * $a);
            return [$x1, $x2];
        }
    }
}