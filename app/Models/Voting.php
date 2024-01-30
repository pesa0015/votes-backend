<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Voting extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'description',
        'closed',
        'pending',
        'user_id',
    ];

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function votesWithSuggestion(): HasMany
    {
        return $this->hasMany(Vote::class)->whereNotNull('suggestion_id');
    }

    public function suggestions(): HasMany
    {
        return $this->hasMany(Suggestion::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
