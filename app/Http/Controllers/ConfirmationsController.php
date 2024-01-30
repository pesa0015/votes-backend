<?php

namespace App\Http\Controllers;

use App\Models\ConfirmationCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfirmationsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        $user = User::firstOrCreate([
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        ConfirmationCode::create([
            'code' => random_int(100000, 999999),
            'user_id' => $user->id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
}
