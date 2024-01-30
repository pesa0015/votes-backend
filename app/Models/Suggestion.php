<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Suggestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'text',
        'voting_id',
    ];

    public function voting(): BelongsTo
    {
        return $this->belongsTo(Voting::class);
    }
}
