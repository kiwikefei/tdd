<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test **/
    public function guest_may_not_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = make('App\Thread');
        $this->post('/threads', $thread->toArray());
    }

    /** @test **/
    public function guest_can_not_see_create_thread_page()
    {
        $this->withExceptionHandling()
            ->get('/threads/create')
            ->assertRedirect('/login');
    }
    /** @test **/
    public function an_authenticated_user_can_create_threads()
    {
        // Given: we have a signed in user
//        $this->be(factory('App\User')->create());
        $this->signIn();
        // When: we hit the endpoint to create a new thread
//        $thread = factory('App\Thread')->raw();   //see notes
        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());
        // Then: when we visit the thread page
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
        // We should see the new thread
    }
    
}
