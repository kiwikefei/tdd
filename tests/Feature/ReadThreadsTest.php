<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @property mixed thread
 */
class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;
    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test **/
    public function a_user_can_read_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /** @test **/
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        // Plans:
        // Given we have a thread
        // And that thread include replies
        // When we visit a thread page
        // Then we should see the replies

        // Action:
        $reply = create('App\Reply',[
            'thread_id' => $this->thread->id
        ]);
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }
    /** @test **/
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');
        $channel2 = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id'=>$channel->id]);
        $threadNotInChannel = create('App\Thread', ['channel_id'=>$channel2->id]);
        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }
    
    /** @test **/
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User', ['name'=>'JohnDoe']));
        $threadByJohn = create('App\Thread', ['user_id'   => auth()->id(), 'title'=>'JohnDoeTitle']);
        $threadNotByJohn= create('App\Thread', ['title'=>'NotJohnDoeTitle']);
        $this->get('/threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }
}
