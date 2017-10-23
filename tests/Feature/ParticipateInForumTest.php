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
        $this->expectException('Illuminate\Auth\AuthenticationException');
//        $thread = factory('App\Thread')->create();
//        $reply = factory('App\Reply')->create();
//        $this->post($thread->path() . '/replies', $reply->toArray());
        $this->post('/threads/1/replies', []);
    }
    
    /** @test **/
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        // Plans
        // Given: we have an authenticated user
        $this->be(factory('App\User')->create());

        // Given: And an existing thread
        $thread = factory('App\Thread')->create();

        // When: the user adds a reply to the thread
//        $reply = factory('App\Reply')->create();  // rather than create() a reply we , just make() it in memory
        $reply = factory('App\Reply')->make();

        $this->post($thread->path() . '/replies', $reply->toArray());

        // Then: their reply should be visible on the page.

        // Action
        $this->get($thread->path())
            ->assertSee($reply->body);

    }
}

