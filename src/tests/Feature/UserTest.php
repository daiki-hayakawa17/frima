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
            'name' => 'お名前を入力してください。',
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
}
