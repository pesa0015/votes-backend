<?php

namespace Database\Seeders;

use App\Models\Voting;
use App\Models\Vote;
use App\Models\User;
use App\Models\Suggestion;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \Artisan::call('migrate:rollback');

        \Artisan::call('migrate');

        $user = User::factory()->create();

        $voting = Voting::factory()->create(['user_id' => $user->id]);

        $suggestions = Suggestion::factory(3)->create(['voting_id' => $voting->id]);

        User::factory(12)->create()->each(function ($user) use ($voting) {
            Vote::factory()->create([
                // 'suggestion_id' => Suggestion::where('voting_id', $voting->id)->inRandomOrder()->first()->id,
                'voting_id' => $voting->id,
            ]);
        });
    }
}
