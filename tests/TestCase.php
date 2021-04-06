<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function singIn($user = null)
    {
        $user = $user ?: create('App\User');

        $this->ActingAs($user);

        return $this;
    }
}
