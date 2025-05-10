<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Course extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'name',
        'thumbnail',
        'about',
        'is_popular',
        'category_id',
        'difficulty',
        'preview_video_url', 
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function benefits(): HasMany
    {
        return $this->hasMany(CourseBenefit::class);
    }


    public function courseSections(): HasMany
    {
        return $this->hasMany(CourseSection::class, 'course_id');
    }

    public function courseStudents(): HasMany
    {
        return $this->hasMany(CourseStudent::class, 'course_id');
    }

    public function courseMentors(): HasMany
    {
        return $this->hasMany(CourseMentor::class, 'course_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getContentCountAttribute()
    {
        return $this->courseSections->sum(function ($section) {
            return $section->sectionContents->count();
        });
    }

    public function learningProgress()
    {
        return $this->hasMany(LearningProgress::class);
    }

    public function getProgressPercentageAttribute()
    {
        if (!auth()->check()) {
            return 0;
        }
        
        $userId = auth()->id();
        $allContentCount = $this->courseSections->flatMap->sectionContents->count();
        
        if ($allContentCount === 0) {
            return 0;
        }
        
        $completedCount = LearningProgress::where('user_id', $userId)
            ->where('course_id', $this->id)
            ->where('is_completed', true)
            ->count();
        
        return $allContentCount > 0 ? round(($completedCount / $allContentCount) * 100) : 0;
    }

    public function isEnrolledByUser($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return false;
        
        return $this->courseStudents()
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->exists();
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class);
    }

    /**
     * Check if course is 100% completed by the current user
     */
    public function isFullyCompletedByUser($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return false;
        
        return $this->progress_percentage == 100;
    }
}
