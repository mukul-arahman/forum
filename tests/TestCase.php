<?php

namespace Tests;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function singIn($user = null)
    {
        $user = $user ?: create('App\User');

        $this->ActingAs($user);

        return $this;
    }
}
