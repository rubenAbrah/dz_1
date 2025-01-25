<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuadraticEquationController;

Route::post('/solve-quadratic-equation', [QuadraticEquationController::class, 'solve']);
