<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_not_favorite_anything()
    {
        $this->post('replies/1/favorites')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_favorite_a_reply()
    {
        $this->withoutExceptionHandling();

        $this->singIn();

        $reply = create('App\Reply');

        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_unfavorite_a_reply()
    {
        $this->withoutExceptionHandling();

        $this->singIn();

        $reply = create('App\Reply');

        $reply->favorite();

        $this->delete('replies/' . $reply->id . '/favorites');
        $this->assertCount(0, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_may_favorite_a_reply_once()
    {
        $this->withoutExceptionHandling();

        $this->singIn();

        $reply = create('App\Reply');

        try {
            $this->post('replies/' . $reply->id . '/favorites');
            $this->post('replies/' . $reply->id . '/favorites');
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record to set twice');
        }

        $this->assertCount(1, $reply->favorites);
    }
}
