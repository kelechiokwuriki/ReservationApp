<?php

namespace App\Services\Utility;

class Utilities
{
    public function arrays_are_equal(array $a, array $b): bool {
        array_multisort($array1);
        array_multisort($array2);
        return ( serialize($array1) === serialize($array2) );
    }
}
