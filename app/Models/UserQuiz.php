<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserQuiz extends Model
{
    protected $fillable = ['user_id', 'quiz_id', 'is_completed', 'answers', 'score'];

    protected $casts = [
        'answers' => 'array', // Cast kolom answers ke array
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
