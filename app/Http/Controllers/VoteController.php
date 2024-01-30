<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVoteRequest;
use App\Models\Vote;
use App\Models\User;
use App\Models\Suggestion;
use Illuminate\Support\Facades\Http;

class VoteController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function show(string $suggestionUuid, string $email)
    {
        $suggestion = Suggestion::where('uuid', $suggestionUuid)->firstOrFail();

        $vote = Vote::where('voting_id', $suggestion->voting->id)
            ->where('email', $email)
            ->firstOrFail();

        $vote->update(['suggestion_id' => $suggestion->id]);

        Http::post('http://localhost:3000', [
            'voteId' => $suggestion->id,
        ]);

        return response()->json();
    }

    /**
     * Update the specified resource in storage
     */
    public function update(string $voteUuid)
    {
        $vote = Voting::where('uuid', $uuid)->firstOrFail();

        $vote->update(['suggestion_id' => null]);

        return response()->json();
    }
}
