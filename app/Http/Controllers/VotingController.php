<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVotingRequest;
use App\Http\Requests\UpdateVotingRequest;
use App\Models\User;
use App\Models\Voting;
use App\Models\Vote;
use App\Models\Suggestion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Ramsey\Uuid\Uuid;

class VotingController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateVotingRequest $request)
    {   
        $emailValidation = Validator::make($request->all(), [
            'invites.*' => 'required|email',
        ]);

        $phoneValidation = Validator::make($request->all(), [
            'invites.*' => 'required|phone',
        ]);

        if ($emailValidation->fails() && $phoneValidation->fails()) {
            throw new ValidationException($phoneValidation);
        }

        $now = Carbon::now();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt('test'),
        ]);

        $voting = Voting::create([
            'uuid' => UUid::uuid4(),
            'user_id' => $user->id,
            'description' => $request->description,
        ]);

        $suggestions = [];

        foreach ($request->suggestions as $suggestion) {
            array_push($suggestions, [
                'uuid' => UUid::uuid4(),
                'voting_id' => $voting->id,
                'text' => $suggestion,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        Suggestion::insert($suggestions);

        $votes = [];

        foreach ($request->invites as $invite) {
            array_push($votes, [
                'uuid' => UUid::uuid4(),
                'email' => str_contains($invite, '@') ? $invite : null,
                'phone' => !str_contains($invite, '@') ? $invite : null,
                'voting_id' => $voting->id,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        Vote::insert($votes);

        return response()->json($voting->uuid);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid)
    {
        $voting = Voting::where('uuid', $uuid)
            ->with('suggestions', 'votes')
            ->firstOrFail()
            ->only(['closed', 'suggestions', 'votes']);

        $filtered = $voting['votes']->filter(function ($item) {
                return $item->suggestion_id !== null;
            });

        $voting['votes'] = $filtered;

        return response()->json($voting);
    }

    /**
     * Update the specified resource in storage
     */
    public function update(string $uuid, UpdateVotingRequest $request)
    {
        $voting = Voting::where('uuid', $uuid)->firstOrFail();

        $voting->update(['closed' => $request->closed]);

        $voting->fresh()->with(['suggestions', 'votes'])
            ->firstOrFail()
            ->only(['closed', 'suggestions', 'votes']);

        return response()->json($voting);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid)
    {
        $voting = Voting::where('uuid', $uuid)->firstOrFail();

        $voting->delete();

        return response()->json();
    }
}
