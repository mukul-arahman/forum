<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $this->withoutExceptionHandling();

        $john = create('App\User', ['name' => 'JohnDoe']);

        $this->singIn($john);

        $jane = create('App\User', ['name' => 'JaneDoe']);

        $thread = create('App\Thread');

        // JohnDoe replies and mentioned to JaneDoe
        $reply = make('App\Reply', [
            'body' => '@JaneDoe look at this. Also @FrankDoe'
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        // JaneDoe should be notified.
        $this->assertCount(1, $jane->notifications);
    }

    /** @test */
    public function it_can_fetch_mentioned_users_starting_with_the_given_characters()
    {
        $this->withoutExceptionHandling();

        create('App\User', ['name' => 'johnDoe']);
        create('App\User', ['name' => 'johnDoe2']);
        create('App\User', ['name' => 'jahnDoe']);

        $results = $this->json('GET', '/api/users', ['name' => 'john']);

        $this->assertCount(2, $results->json());
    }
}
