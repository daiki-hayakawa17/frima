<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;
    
    public function test_user_can_comment_an_item()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        $profile = Profile::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->from("/item/{$item->id}")->post("/comments/{$item->id}", [
            'comment' => 'テストコメント',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('comments', [
            'comment' => 'テストコメント',
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertSeeText('テストコメント');

        $item->refresh();

        $this->assertEquals(1, $item->comments()->count());
    }

    public function test_guest_can_not_comment_an_item()
    {
        $item = Item::factory()->create();

        $response = $this->from("/item/{$item->id}")->post("/comments/{$item->id}", [
            'comment' => 'テストコメント',
        ]);

        $response->assertRedirect('login');

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
            'comment' => 'テストコメント',
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertDontSee('テストコメント');

        $item->refresh();

        $this->assertEquals(0, $item->comments()->count());
    }

    public function test_comment_fails_without_comment()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        $profile = Profile::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->from("/item/{$item->id}")->post("/comments/{$item->id}", [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response->assertRedirect("/item/{$item->id}");

       $response->assertSessionHasErrors([
            'comment' => 'コメントを入力してください',
       ]);

       $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
       ]);
    }

    public function test_comment_fails_without_comment_max()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        $profile = Profile::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $tooLongComment = str_repeat('あ', 256);

        $response = $this->from("/item/{$item->id}")->post("/comments/{$item->id}", [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => $tooLongComment,
        ]);

        $response->assertRedirect("/item/{$item->id}");

       $response->assertSessionHasErrors([
            'comment' => 'コメントを255文字以内で入力してください',
       ]);

       $this->assertDatabaseMissing('comments', [
            'comment' => $tooLongComment,
       ]);
    }
}
