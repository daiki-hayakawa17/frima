<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Delivery;
use App\Models\Profile;

class PurchaseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_user_can_purchase_item_successfully()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'pay' => 1,
        ]);

        $profile = Profile::factory()->create([
            'user_id' => $user->id,
        ]);

        $delivery = Delivery::factory()->create([
            'user_id' => $profile->user_id,
            'post' => $profile->post,
            'address' => $profile->address,
        ]);

        $this->actingAs($user);

        $response = $this->from("/purchase/{$item->id}")->post(route('purchase.buy', $item->id), [
            'user_id' => $user->id,
            'delivery_id' => $delivery->id,
            'pay' => $item->pay,
            'post' => $delivery->post,
            'address' => $delivery->address,
        ]);

        $this->assertDatabaseHas('items', [
            'delivery_id' => $delivery->id,
            'purchaser_id' => $profile->user_id,
        ]);
    }

    public function test_index_page_displays_sold_for_purchased_item()
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

        $response = $this->get('/');

        $response->assertDontSee('1つ目の商品');

        $response->assertSee('2つ目の商品');

        $response->assertSee('sold');
    }

    public function test_mypage_displays_purchased_item()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'name' => '購入商品',
            'purchaser_id' => $user->id,
            'pay' => 1,
        ]);

        $profile = Profile::factory()->create([
            'user_id' => $user->id,
        ]);
        
        $this->assertDatabaseHas('items', [
            'purchaser_id' => $user->id,
            'name' => '購入商品',
        ]);

        $response = $this->actingAs($user)->get('/mypage?mypage=buy');

        
        $response->assertSee('購入商品');
    }
}
