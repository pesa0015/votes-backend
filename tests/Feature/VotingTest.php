<?php

namespace Tests\Feature;

use Tests\TestCase;

class VotingTest extends TestCase
{
    /**
     * Test store a voting
     */
    public function test_store_a_voting(): void
    {
        $data = [
            'name' => 'test',
            'email' => 'test@gmail.com',
            'description' => 'test',
            'suggestions' => ['test'],
            'invites' => ['test@gmail.com'],
        ];
        $response = $this->postJson('/api/votings', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('votings', [
            'description' => $data['description'],
        ]);

        $this->assertDatabaseHas('suggestions', [
            'text' => $data['suggestions'][0],
        ]);
    }
}
