<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectionContent extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'name',
        'course_section_id',
        'content',
        'type', // Tambahkan ini
        'video_url', // Tambahkan ini
    ];

    protected static function booted()
    {
        static::creating(function ($sectionContent) {
            if ($sectionContent->type === 'video' && empty($sectionContent->content)) {
                $sectionContent->content = ''; // Berikan nilai default kosong
            }
        });

        static::saving(function ($sectionContent) {
            if ($sectionContent->type === 'video' && !empty($sectionContent->video_url)) {
                // Ubah URL menjadi format embed jika belum
                if (strpos($sectionContent->video_url, 'embed/') === false) {
                    if (strpos($sectionContent->video_url, 'youtu.be/') !== false) {
                        // Konversi URL pendek menjadi embed
                        $sectionContent->video_url = str_replace('youtu.be/', 'www.youtube.com/embed/', $sectionContent->video_url);
                    } elseif (strpos($sectionContent->video_url, 'watch?v=') !== false) {
                        // Konversi URL panjang menjadi embed
                        $sectionContent->video_url = str_replace('watch?v=', 'embed/', $sectionContent->video_url);
                    }
                }
            }
        });
    }

    public function courseSection(): BelongsTo
    {
        return $this->belongsTo(CourseSection::class, 'course_section_id');
    }

    public function learningProgress()
    {
        return $this->hasMany(LearningProgress::class);
    }

    public function isCompletedByUser($userId = null)
    {
        $userId = $userId ?? auth()->id();
        if (!$userId) return false;
        
        return $this->learningProgress()
            ->where('user_id', $userId)
            ->where('is_completed', true)
            ->exists();
    }
}
