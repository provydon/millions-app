<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_create_post()
    {
        $this->actingAs(User::factory()->create());
        
        $response = $this->post('/api/posts', [
            "description"=>"test post",
        ]);

        $response->assertStatus(200);
    }

    public function test_public_feed_returns_a_successful_response()
    {
        $response = $this->get('/api/posts');

        $response->assertStatus(200);
    }

    public function test_user_can_view_specific_post()
    {
        $post = Post::factory()->create();
        
        $response = $this->get("/api/posts/$post->id");

        $response->assertStatus(200);
    }

    public function test_user_can_like_post()
    {
        $this->actingAs(User::factory()->create());

        $post = Post::factory()->create();
        
        $response = $this->get("/api/like-post?post_id=$post->id");

        $response->assertStatus(200);
    }

    public function test_user_can_unlike_post()
    {
        $this->actingAs(User::factory()->create());

        $post = Post::factory()->create();
        
        $response = $this->get("/api/unlike-post?post_id=$post->id");

        $response->assertStatus(200);
    }

    public function test_user_can_see_likes_of_specific_post()
    {
        $post = Post::factory()->create();
        
        $response = $this->get("/api/posts/$post->id/likes");

        $response->assertStatus(200);
    }

    public function test_user_can_delete_post()
    {
        $this->actingAs(User::factory()->create());

        $post = Post::factory()->create();
        
        $response = $this->delete("/api/posts/$post->id");

        $response->assertStatus(200);
    }
}
