<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Voting;
use App\Models\Vote;
use App\Models\Suggestion;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class VoteTest extends TestCase
{
    /**
     * Test get a voting
     */
    public function test_get_a_vote(): void
    {
        $user = User::factory()->create();

        $voting = Voting::factory()->create([
            'user_id' => $user->id,
        ]);

        $suggestions = Suggestion::factory()->count(2)->create([
            'voting_id' => $voting->id,
        ]);

        $votes = Vote::factory()->count(2)->create([
            'voting_id' => $voting->id,
            'email' => 'test@example.com',
        ]);

        Http::fake();

        $response = $this->get('/api/vote/' . $suggestions->first()->uuid . '/test@example.com');

        $response->assertStatus(200);

        $this->assertDatabaseHas('votes', [
            'suggestion_id' => $suggestions->first()->id,
        ]);
    }
}
