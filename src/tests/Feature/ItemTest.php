<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\Category;
use App\Models\Profile;

class ItemTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_items_displayed_on_index_page()
    {
        $this->seed(\Database\Seeders\ItemTableSeeder::class);

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee('腕時計');
    }

    public function test_purchased_item_is_marked_as_sold()
    {
        $this->seed(\Database\Seeders\ItemTableSeeder::class);

        $user = User::factory()->create();

        $item = Item::first();

        $item->update([
            'purchaser_id' => $user->id,
        ]);

        $response = $this->get('/');

        $response->assertSee('タンブラー');

        $response->assertSee('sold');

        $response->assertDontSee($item->name);
    }

    public function test_seller_cannot_see_own_item()
    {
        $user = User::factory()->create();

        Item::factory()->create([
            'name' => '自分の商品',
            'seller_id' => $user->id,
        ]);

        Item::factory()->create([
            'name' => '他人の商品',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertDontSee('自分の商品');

        $response->assertSee('他人の商品');
    }

    public function test_like_items_displayed_on_mylist()
    {
        $user = User::factory()->create();

        $item1 = Item::factory()->create([
            'name' => 'テスト商品',
        ]);

        $item2 = Item::factory()->create([
            'name' => 'いいねした商品',
        ]);

        Like::factory()->create([
            'item_id' => $item2->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/?page=mylist');

        $response->assertDontSee('テスト商品');

        $response->assertSee('いいねした商品');
    }

    public function test_purchased_items_show_sold_in_mylist()
    {
        $user = User::factory()->create();

        $item1 = Item::factory()->create([
            'name' => '1つ目の商品',
            'purchaser_id' => $user->id,
        ]);

        $item2 = Item::factory()->create([
            'name' => '2つ目の商品',
            'purchaser_id' => null,
        ]);

        Like::factory()->create([
            'item_id' => $item1->id,
            'user_id' => $user->id,
        ]);

        Like::factory()->create([
            'item_id' => $item2->id,
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/?page=mylist');

        $response->assertDontSee('1つ目の商品');

        $response->assertSee('2つ目の商品');

        $response->assertSee('sold');
    }

    public function test_my_list_does_not_include_my_own_items()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'name' => '出品商品',
            'seller_id' => $user->id,
        ]);

        Like::factory()->create([
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?page=mylist');

        $response->assertDontSee('出品商品');
    }

    public function test_guest_cannot_see_items_in_mylist()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'name' => 'テスト商品',
        ]);

        Like::factory()->create([
            'item_id' => $item->id,
            'user_id' => $user->id,
        ]);

        $response = $this->get('/?page=mylist');

        $response->assertDontSee('テスト商品');
    }

    public function test_keyword_serach_returns_matching_items()
    {
        $this->seed(\Database\Seeders\ItemTableSeeder::class);

        $response = $this->get('/?keyword=腕時計');

        $response->assertSee('腕時計');

        $response->assertDontSee('革靴');
    }

    public function test_mylist_search_returns_matching_items()
    {
        $user = User::factory()->create();

        $item1 = Item::factory()->create([
            'name' => '腕時計',
        ]);

        $item2 = Item::factory()->create([
            'name' => 'いいねした商品',
        ]);

        Like::factory()->create([
            'item_id' => $item1->id,
            'user_id' => $user->id,
        ]);

        Like::factory()->create([
            'item_id' => $item2->id,
            'user_id' => $user->id,
        ]);

        

        $response = $this->actingAs($user)->get('/?page=mylist&keyword=腕');

        $response->assertSee('腕時計');

        $response->assertDontSee('いいねした商品');
    }

    public function test_item_displayed_on_detail_page()
    {
        $item = Item::factory()->create([
            'name' => 'テスト商品',
            'image' => 'default.png',
            'price' => 5000,
            'description' => 'テスト商品です',
            'condition' => 1,
        ]);

        $category = Category::factory()->create([
            'content' => 'メンズ',
        ]);

        $item->categories()->attach($category->id);

        $response = $this->get("/item/{$item->id}");

        $response->assertSee('default.png');

        $response->assertStatus(200);

        $response->assertSee('テスト商品');

        $response->assertSee('5000');

        $response->assertSee('テスト商品です');

        $response->assertSee('メンズ');

        $response->assertSee('良好');

        $response->assertSee('コメント（0）');
    }

    public function test_item_detail_displays_multiple_categories()
    {
        $item = Item::factory()->create(
        );

        $category1 = Category::factory()->create(['content' => '家電']);

        $category2 = Category::factory()->create(['content' => 'ゲーム']);

        $item->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        $response->assertSee('家電');

        $response->assertSee('ゲーム');
    }

    public function test_item_can_be_registered_by_seller()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $category = Category::factory()->create([
            'content' => 'メンズ',
        ]);

        $response = $this->from('/sell')->post('/sell', [
            'item__image' => UploadedFile::fake()->image('test.png'),
            'condition' => 1,
            'name' => 'テスト商品',
            'description' => 'テスト用の商品です',
            'price' => 500,
            'seller_id' => $user->id,
            'categories' => [$category->id],
        ]);

        $this->assertDatabaseHas('items', [
            'image' => 'storage/images/test.png',
            'condition' => 1,
            'name' => 'テスト商品',
            'description' => 'テスト用の商品です',
            'price' => 500,
            'seller_id' => $user->id,
        ]);

        $item = Item::where('name', 'テスト商品')->first();

        $this->assertTrue($item->categories->contains('id', $category->id));
    }
}
