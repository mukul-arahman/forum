<?php

namespace App\Inspections;

use App\Inspections\KeyHeldDown;
use App\Inspections\InvalidKeyWords;

class Spam
{
    protected $inspections = [
        InvalidKeyWords::class,
        KeyHeldDown::class
    ];

    public function detect($body)
    {
        foreach ($this->inspections as $insepection) {
            app($insepection)->detect($body);
        }

        return false;
    }
}
