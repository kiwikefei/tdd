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
//        $this->expectException('Illuminate\Auth\AuthenticationException');
//        $thread = make('App\Thread');
//        $this->post('/threads', $thread->toArray());
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads',[])
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
        // see No.12 @ notes.txt
        $response = $this->post('/threads', $thread->toArray());
        $path = $response->headers->get('Location');
        // Then: when we visit the thread page
        $this->get($path)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
        // We should see the new thread
    }
    
    /** @test **/
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');

    }

    /** @test **/
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');

    }

    /** @test **/
    public function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 3])
            ->assertSessionHasErrors('channel_id');
    }
    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()
            ->signIn();

        $thread = make('App\Thread',$overrides);

        return $this->post('/threads', $thread->toArray());
    }
    
}
