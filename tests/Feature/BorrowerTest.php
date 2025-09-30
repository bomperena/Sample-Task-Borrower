<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class BorrowerTest extends TestCase
{
use RefreshDatabase;


public function test_can_create_borrower()
{
$payload = [
'name' => 'Alice',
'email' => 'alice@example.com',
'phone' => '09171234567',
'status' => 'active',
];


$this->postJson('/api/borrowers', $payload)
->assertStatus(201)
->assertJsonStructure(['data' => ['id','name','email','phone','status','created_at']]);


$this->assertDatabaseHas('borrowers', ['email' => 'alice@example.com']);
}
}