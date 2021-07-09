<?php

namespace App\Services\Utility;

class Utilities
{
    public function arrays_are_equal(array $a, array $b): bool {
        array_multisort($a);
        array_multisort($b);
        return ( serialize($a) === serialize($b) );
    }
}
