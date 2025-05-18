<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

     use RefreshDatabase;

    public function test_register_fails_without_name()
    {
        $response = $this->from('/register')->post('/register', [
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('/register');

        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => 'test@example.com',
        ]);
    }

    public function test_register_fails_without_email()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'testuser',
            'password' => 'password',
            'password_confimation' => 'password',
        ]);

        $response->assertRedirect('/register');

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);

        $this->assertDatabaseMissing('users', [
            'name' => 'testuser',
        ]);
    }

    public function test_register_fails_without_password()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'testuser',
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect('/register');

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);

        $this->assertDatabaseMissing('users', [
            'name' => 'testuser',
        ]);
    }

    public function test_register_fails_without_short_password()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
        ]);

        $response->assertRedirect('/register');

        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください'
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => 'test@example.com',
        ]);
    }

    public function test_register_fails_without_password_confirmation()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'testuser',
            'email' => 'test@examople.com',
            'password' => 'test1234',
            'password_confirmation' => 'test5678',
        ]);

        $response->assertRedirect('/register');

        $response->assertSessionHasErrors([
            'password' => 'パスワードと一致しません'
        ]);

        $this->assertDatabaseMissing('users', [
            'email' => 'test@example.com',
        ]);
    }

    public function test_register_success()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'test1234',
            'password_confirmation' => 'test1234',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseHas('users', [
            'name' => 'testuser',
            'email' => 'test@example.com',
        ]);
    }

    public function test_login_fails_without_email()
    {
        $response = $this->from('/login')->post('/login', [
            'password' => 'test1234',
        ]);

        $response->assertRedirect('/login');

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    public function test_login_fails_without_password()
    {
        $response = $this->from('/login')->post('/login', [
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect('/login');

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }

    public function test_login_fails_without_no_data()
    {
        $response = $this->from('/login')->post('/login',[
            'email' => 'test1@example.com',
            'password' => 'test5678',
        ]);

        $response->assertRedirect('/login');

        $response->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません',
        ]);
    }

    public function test_login_success()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('test1234'),
        ]);

        $response = $this->from('/login')->post('/login',[
            'email' => 'test@example.com',
            'password' => 'test1234',
        ]);

        $this->assertAuthenticatedAs($user);
    }

    public function test_logout_success()
    {
        $user = \App\Models\User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);

        $response = $this->post('/logout');

        $this->assertGuest();
    }
}
