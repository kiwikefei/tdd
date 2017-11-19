<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    /** @test * */
    public function guest_can_not_favorite_anything()
    {
        $this->withExceptionHandling()
            ->post('/replies/1/favorites')
            ->assertRedirect('/login');
    }

    /** @test * */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');
        // /replies/id/favorite
        $this->post('/replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }
    
    /** @test **/
    public function an_authenticated_user_can_only_favorite_a_reply_once()
    {
        $this->signIn();
        $reply = create('App\Reply');
        try{
            $this->post('/replies/' . $reply->id . '/favorites');
            $this->post('/replies/' . $reply->id . '/favorites');
        }catch(\Exception $e){
            $this->fail('Did not expect to inst the same record set more than once.');
        }

        $this->assertCount(1, $reply->favorites);
    }
}
