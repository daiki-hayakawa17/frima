<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class LikeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function test_user_can_like_an_item()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/like/{$item->id}");

        $response->assertStatus(302);

        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $item->refresh();

        $this->assertEquals(1, $item->likes()->count());
    }

    public function test_user_liked_icon_color_change()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        $this->actingAs($user)->post("/like/{$item->id}");

        $response = $this->actingAs($user)->get("/item/{$item->id}");

        $response->assertSee('1');

        $this->assertStringContainsString('action="/unlike/' . $item->id . '"', $response->getContent());
    }

    public function test_user_can_unlike_an_item()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/like/{$item->id}");

        $response = $this->post("/unlike/{$item->id}");

        $response->assertStatus(302);

        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $item->refresh();

        $this->assertEquals(0, $item->likes()->count());
    }
}
