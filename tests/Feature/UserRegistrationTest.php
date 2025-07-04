<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('user can view registration form', function () {
    $response = $this->get('/register');
    $response->assertStatus(200);
});

test('user can register with valid data', function () {
    Storage::fake('public');

    $ktpFile = UploadedFile::fake()->image('ktp.jpg');
    $kkFile = UploadedFile::fake()->image('kk.jpg');

    $userData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'nik' => '1234567890123456',
        'gender' => 'L',
        'birth_date' => '1990-01-01',
        'address' => 'Test Address',
        'phone' => '081234567890',
        'kk_number' => '1234567890123456',
        'rt_rw' => 'RT 01/RW 01',
        'ktp_photo' => $ktpFile,
        'kk_photo' => $kkFile,
    ];

    $response = $this->post('/register', $userData);

    $response->assertRedirect('/verification-notice');
    $this->assertDatabaseHas('users', [
        'email' => 'test@example.com',
        'nik' => '1234567890123456',
        'is_verified' => false,
    ]);
});

test('user cannot register with duplicate email', function () {
    User::factory()->create(['email' => 'test@example.com']);

    $userData = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'nik' => '1234567890123456',
        'gender' => 'L',
        'birth_date' => '1990-01-01',
        'address' => 'Test Address',
        'phone' => '081234567890',
        'kk_number' => '1234567890123456',
        'rt_rw' => 'RT 01/RW 01',
    ];

    $response = $this->post('/register', $userData);
    $response->assertSessionHasErrors('email');
});

test('unverified user cannot access protected routes', function () {
    $user = User::factory()->create(['is_verified' => false]);

    $response = $this->actingAs($user)->get('/letter-requests');
    $response->assertRedirect('/verification-notice');
});

test('verified user can access protected routes', function () {
    $user = User::factory()->create(['is_verified' => true]);

    $response = $this->actingAs($user)->get('/letter-requests');
    $response->assertStatus(200);
});
