<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test **/
    public function unauthenticated_users_may_not_add_replies()
    {
//        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->withExceptionHandling()
            ->post('/threads/channel-slug/1/replies', [])
            ->assertRedirect('login');

//        $thread = factory('App\Thread')->create();
//        $reply = factory('App\Reply')->create();
//        $this->post($thread->path() . '/replies', $reply->toArray());
    }
    
    /** @test **/
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        // Plans
        // Given: we have an authenticated user
        $this->signIn();
        // Given: And an existing thread
        $thread = create('App\Thread');

        // When: the user adds a reply to the thread
//        $reply = factory('App\Reply')->create();  // rather than create() a reply we , just make() it in memory
        $reply = make('App\Reply');

        $this->post($thread->path() . '/replies', $reply->toArray());

        // Then: their reply should be visible on the page.

        // Action
        $this->get($thread->path())
            ->assertSee($reply->body);

    }
}

