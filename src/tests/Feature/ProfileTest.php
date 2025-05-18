<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;

class ProfileTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_mypage_displays_required_information()
    {
        $user = User::factory()->create();

        $item1 = Item::factory()->create([
            'name' => '購入商品',
            'purchaser_id' => $user->id,
        ]);

        $item2 = Item::factory()->create([
            'name' => '出品商品',
            'seller_id' => $user->id,
        ]);

        $profile = Profile::factory()->create([
            'user_id' => $user->id,
            'name' => 'テストユーザー',
            'image' => 'test.png',
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage');

        $response->assertSee('テストユーザー');

        $response->assertSee('test.png');

        $response = $this->get('/mypage?mypage=sell');

        $response->assertSee('出品商品');

        $response = $this->get('/mypage?mypage=buy');

        $response->assertSee('購入商品');
    }

    public function test_profile_edit_page_displays_current_user_info()
    {
        $user = User::factory()->create();

        $profile = Profile::factory()->create([
            'user_id' => $user->id,
            'name' => 'テストユーザー',
            'image' => 'test.png',
            'post' => '000-1234',
            'address' => '東京都渋谷区千駄ヶ谷1-2-3',
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage/profile');

        $response->assertSee('テストユーザー');

        $response->assertSee('test.png');

        $response->assertSee('000-1234');

        $response->assertSee('東京都渋谷区千駄ヶ谷1-2-3');
    }
}
