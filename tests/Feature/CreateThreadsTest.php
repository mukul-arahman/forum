<?php

namespace Tests\Feature;

use App\Activity;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->get('/threads/create')
            ->assertRedirect('login');

        $this->post('/threads')
            ->assertRedirect('login');
    }

    /** @test */
    public function authenticated_users_must_first_confirm_their_email_address_before_creating_threads()
    {
        $this->publishThread()
            ->assertRedirect('/threads')
            ->assertSessionHas('flash', 'You must first confirm your email address');
    }

    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        $this->withoutExceptionHandling();

        $this->singIn();

        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function publishThread($overrides = [])
    {
        $this->singIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }


    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function unauthorized_users_may_not_delete_threads()
    {
        $thread = create('App\Thread');

        $this->delete($thread->path())->assertRedirect('/login');

        $this->singIn();
        $this->delete($thread->path())->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->withoutExceptionHandling();

        $this->singIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, Activity::count());
    }
}
