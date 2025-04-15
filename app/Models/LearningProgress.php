<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LearningProgress extends Model
{
    protected $table = 'learning_progress';
    
    protected $fillable = [
        'user_id',
        'course_id',
        'course_section_id',
        'section_content_id',
        'is_completed',
    ];
    
    protected $casts = [
        'is_completed' => 'boolean',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
    
    public function courseSection(): BelongsTo
    {
        return $this->belongsTo(CourseSection::class);
    }
    
    public function sectionContent(): BelongsTo
    {
        return $this->belongsTo(SectionContent::class);
    }
}
