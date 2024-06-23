<?php

class RegresiLinier
{
    public $all;

    public function __construct($x, $y)
    {
        $this->all = $this->linearRegression($x, $y);
    }

    private function linearRegression($x, $y)
    {
        $n = count($x);
        $x_sum = array_sum($x);
        $y_sum = array_sum($y);
        $x2_sum = array_sum(array_map(fn($val) => $val * $val, $x));
        $xy_sum = array_sum(array_map(fn($i) => $x[$i] * $y[$i], range(0, $n - 1)));

        $slope = ($n * $xy_sum - $x_sum * $y_sum) / ($n * $x2_sum - $x_sum * $x_sum);
        $intercept = ($y_sum - $slope * $x_sum) / $n;

        $line = array_map(fn($x_val) => $slope * $x_val + $intercept, $x);
        return $line;
    }

    public function predict($x)
    {
        $line = $this->all;
        $last_point = end($line);
        $second_last_point = prev($line);
        $slope = $last_point - $second_last_point;

        return $last_point + $slope;
    }
}

?>