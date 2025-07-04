<?php

use App\Models\User;
use App\Models\LetterType;
use App\Models\LetterRequest;

test('verified user can create letter request', function () {
    $user = User::factory()->create(['is_verified' => true]);
    $letterType = LetterType::factory()->create([
        'name' => 'Surat Keterangan Domisili',
        'required_fields' => ['keperluan' => 'text']
    ]);

    $response = $this->actingAs($user)->post('/letter-requests', [
        'letter_type_id' => $letterType->id,
        'form_data' => [
            'keperluan' => 'Administrasi Bank'
        ]
    ]);

    $response->assertRedirect('/letter-requests');
    $this->assertDatabaseHas('letter_requests', [
        'user_id' => $user->id,
        'letter_type_id' => $letterType->id,
        'status' => 'pending_rt'
    ]);
});

test('user can view their letter requests', function () {
    $user = User::factory()->create(['is_verified' => true]);
    $letterType = LetterType::factory()->create();
    $letterRequest = LetterRequest::factory()->create([
        'user_id' => $user->id,
        'letter_type_id' => $letterType->id
    ]);

    $response = $this->actingAs($user)->get('/letter-requests');
    $response->assertStatus(200);
    $response->assertSee($letterRequest->request_number);
});

test('user cannot view other users letter requests', function () {
    $user1 = User::factory()->create(['is_verified' => true]);
    $user2 = User::factory()->create(['is_verified' => true]);
    $letterType = LetterType::factory()->create();
    $letterRequest = LetterRequest::factory()->create([
        'user_id' => $user2->id,
        'letter_type_id' => $letterType->id
    ]);

    $response = $this->actingAs($user1)->get("/letter-requests/{$letterRequest->id}");
    $response->assertStatus(403);
});

test('rt can approve letter request', function () {
    $rt = User::factory()->create(['role' => 'rt', 'is_verified' => true]);
    $user = User::factory()->create(['is_verified' => true, 'rt_rw' => 'RT 01/RW 01']);
    $letterType = LetterType::factory()->create();
    $letterRequest = LetterRequest::factory()->create([
        'user_id' => $user->id,
        'letter_type_id' => $letterType->id,
        'status' => 'pending_rt'
    ]);

    $response = $this->actingAs($rt)->patch("/approvals/{$letterRequest->id}/approve", [
        'notes' => 'Approved by RT'
    ]);

    $response->assertRedirect('/approvals');
    $this->assertDatabaseHas('letter_requests', [
        'id' => $letterRequest->id,
        'status' => 'pending_rw'
    ]);
});

test('rw can approve letter request and trigger pdf generation', function () {
    $rw = User::factory()->create(['role' => 'rw', 'is_verified' => true]);
    $user = User::factory()->create(['is_verified' => true, 'rt_rw' => 'RT 01/RW 01']);
    $letterType = LetterType::factory()->create();
    $letterRequest = LetterRequest::factory()->create([
        'user_id' => $user->id,
        'letter_type_id' => $letterType->id,
        'status' => 'pending_rw'
    ]);

    $response = $this->actingAs($rw)->patch("/approvals/{$letterRequest->id}/approve", [
        'notes' => 'Approved by RW'
    ]);

    $response->assertRedirect('/approvals');
    $this->assertDatabaseHas('letter_requests', [
        'id' => $letterRequest->id,
        'status' => 'approved_final'
    ]);
});
