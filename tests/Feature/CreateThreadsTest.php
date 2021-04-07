<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->withoutExceptionHandling();

        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    public function guests_can_not_see_the_create_thread_page()
    {
        $this->get('/threads/create')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_can_create_forum_threads()
    {
        $this->singIn();

        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());

        $response = $this->get($thread->path());

        $response->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
