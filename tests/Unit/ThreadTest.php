<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    public function setUp()
    {
       parent::setUp();
       $this->thread = create('App\Thread');
    }

    /** @test **/
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    /** @test **/
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }


    /** @test **/
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
           'body'       => 'foobar',
           'user_id'    => 1
        ]);
        $this->assertCount(1, $this->thread->replies);
    }
    
    /** @test **/
    public function a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }
    
    /** @test **/
    public function a_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');
        // if you need an id from factory, you need to persist it first,
        // so that's why we use create() rather than make().
        $this->assertEquals(
            "/threads/{$thread->channel->slug}/$thread->id" ,
            $thread->path()
        );
    }

    /** @test **/
    public function a_user_can_filter_threads_by_popularity()
    {
        // Given we have 3 threads
        // With 2 replies, 3 replies, and 0 replies respectively
        $threadWithTweReplies = create('App\Thread');
        create('App\Reply', ['thread_id'=>$threadWithTweReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id'=>$threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;
        // When filtering all threads by popularity
        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3,2,0],array_column($response, 'replies_count'));
        // Then they should be return from most replies to least.
    }
}
