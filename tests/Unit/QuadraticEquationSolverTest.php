<?php

namespace Tests\Unit;

use Tests\TestCase;
use InvalidArgumentException;
use App\Services\QuadraticEquationSolver;

class QuadraticEquationSolverTest extends TestCase
{
    public function testNoRealRoots()
    {
        $result = QuadraticEquationSolver::solve(1, 0, 1);
        $this->assertEmpty($result);
    }

    public function testTwoRealRoots()
    {
        $result = QuadraticEquationSolver::solve(1.0, 0.0, -1.0);
        sort($result);
        $this->assertEqualsWithDelta([-1.0, 1.0], $result, 1e-8);
    }

    public function testOneRealRootWithMultiplicityTwo()
    {
        $result = QuadraticEquationSolver::solve(1, 2, 1);
        $this->assertEquals([-1, -1], $result);
    }

    public function testAZeroThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        QuadraticEquationSolver::solve(0, 1, 1);
    }

    public function testAEpsilonThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        QuadraticEquationSolver::solve(1e-9, 1, 1);
    }

    public function testDiscriminantEpsilon()
    {
        // Подбираем коэффициенты так, чтобы D = 1e-12 (меньше epsilon = 1e-8)
        $a = 1.0;
        $b = 2.0;
        $c = 1.0 - 1e-12 / 4; // D = b² - 4ac = 4 - 4*(1 - 1e-12/4) = 1e-12

        $result = QuadraticEquationSolver::solve($a, $b, $c);
        $this->assertEqualsWithDelta([-1.0, -1.0], $result, 1e-8);
    }

    public function testNonNumericCoefficients()
    {
        $this->expectException(InvalidArgumentException::class);
        QuadraticEquationSolver::solve(NAN, 1, 1);

        $this->expectException(InvalidArgumentException::class);
        QuadraticEquationSolver::solve(INF, 1, 1);

        $this->expectException(InvalidArgumentException::class);
        QuadraticEquationSolver::solve(1, NAN, 1);

        $this->expectException(InvalidArgumentException::class);
        QuadraticEquationSolver::solve(1, 1, INF);
    }
}