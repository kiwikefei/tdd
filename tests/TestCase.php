<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    // an optional choice
//    public function signIn($user)
//    {
//        $this->be($user);
//    }
}
