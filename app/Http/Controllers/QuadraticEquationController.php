<?php

namespace App\Http\Controllers;

use App\Services\QuadraticEquationSolver;
use Illuminate\Http\Request;

class QuadraticEquationController extends Controller
{
    public function solve(Request $request)
    {
        $validated = $request->validate([
            'a' => 'required|numeric',
            'b' => 'required|numeric',
            'c' => 'required|numeric'
        ]);

        try {
            $roots = QuadraticEquationSolver::solve(
                $validated['a'],
                $validated['b'],
                $validated['c']
            );

            return response()->json([
                'roots' => $roots,
                'equation' => "{$validated['a']}x² + {$validated['b']}x + {$validated['c']} = 0"
            ]);

        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
