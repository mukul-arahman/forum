<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddAvatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function only_members_can_add_avatars()
    {
        $this->json('POST', 'api/users/1/avatar')
            ->assertStatus(401);
    }

    /** @test */
    public function a_valid_avatar_must_be_provided()
    {
        $this->singIn();

        $response = $this->json('POST', 'api/users/' . auth()->id() . '/avatar', [
            'avatar' => 'not-a-valid-image'
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function a_user_may_add_an_avatar_to_their_profile()
    {
        $this->withoutExceptionHandling();

        $this->singIn();

        Storage::fake('public');

        $this->json('POST', 'api/users/' . auth()->id() . '/avatar', [
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg')
        ]);

        $this->assertEquals(asset('storage/avatars/'.$file->hashName()), auth()->user()->avatar_path);

        Storage::disk('public')->assertExists('avatars/' . $file->hashName());
    }
}
