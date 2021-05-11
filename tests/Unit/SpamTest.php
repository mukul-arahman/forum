<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Utilities\Spam;

class SpamTest extends TestCase
{

    /** @test */
    public function it_validates_spam()
    {
        $this->withoutExceptionHandling();

        $spam = new Spam();

        $this->assertFalse($spam->detect('Innocent reply here'));
    }
}
