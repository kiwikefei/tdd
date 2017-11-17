<?php

namespace Tests;

use App\Exceptions\Handler;
use DatabaseSeeder;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * @property ExceptionHandler|mixed oldExceptionHandler
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp()
    {
        parent::setUp();
//        $this->artisan('db:seed');  keep database clean when a test case starts.
//        $this->disableExceptionHandling();
        $this->withoutExceptionHandling();
    }
// withoutExceptionHandling() and withExceptionHandling() provide by Laravel 5.4+ out of box.

//    protected function disableExceptionHandling()
//    {
//        $this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);
//
//        $this->app->instance(ExceptionHandler::class, new class extends Handler {
//            /**
//             *  constructor.
//             */
//            public function __construct() {}
//            public function report(\Exception $e) {}
//            public function render($request, \Exception $e) {
//                throw $e;
//            }
//        });
//    }
//    protected function withExceptionHandling()
//    {
//        $this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);
//
//        return $this;
//    }
    protected function signIn($user = null)
    {
        $user = $user ?: create('App\User');
        $this->actingAs($user);
        return $this;
    }
}
