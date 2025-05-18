<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Delivery;
use App\Models\Item;
use App\Models\Profile;

class DeliveryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use RefreshDatabase;

    public function test_address_is_updated_on_purchase_page_after_change()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        $delivery = Delivery::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->from("/purchase/address/{$item->id}")->post("/purchase/address/{$item->id}", [
            'user_id' => $user->id,
            'post' => '123-4567',
            'address' => '東京都渋谷区千駄ヶ谷1-2-3',
            'building' => 'haitu12',
        ]);

        $response->assertRedirect("/purchase/{$item->id}");

        $this->assertDatabaseHas('deliveries', [
            'post' => '123-4567',
            'address' => '東京都渋谷区千駄ヶ谷1-2-3',
            'building' => 'haitu12',
        ]);

        $response = $this->get("/purchase/{$item->id}");

        $response->assertSee('123-4567');

        $response->assertSee('東京都渋谷区千駄ヶ谷1-2-3');

        $response->assertSee('haitu12');
    }

    public function test_delivery_is_saved_when_item_is_purchased()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create([
            'pay' => 1,
        ]);

        $delivery = Delivery::factory()->create([
            'user_id' => $user->id,
        ]);

        $profile = Profile::factory()->create([
            'user_id' => $user->id,
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
        ]);
    }
}
