<?php

namespace App\Services;

use App\Models\Course;
use App\Models\LearningProgress;
use App\Models\SectionContent;
use Illuminate\Support\Facades\Auth;

class LearningProgressService
{
    /**
     * Mark a content as completed for the current user
     */
    public function markContentAsCompleted(SectionContent $content)
    {
        $user = Auth::user();
        if (!$user) return false;
        
        $courseSection = $content->courseSection;
        $course = $courseSection->course;
        
        return LearningProgress::updateOrCreate(
            [
                'user_id' => $user->id,
                'section_content_id' => $content->id,
            ],
            [
                'course_id' => $course->id,
                'course_section_id' => $courseSection->id,
                'is_completed' => true,
            ]
        );
    }
    
    /**
     * Get all completed content IDs for a user in a course
     */
    public function getCompletedContentIds(int $userId, int $courseId)
    {
        return LearningProgress::where('user_id', $userId)
            ->where('course_id', $courseId)
            ->where('is_completed', true)
            ->pluck('section_content_id')
            ->toArray();
    }
    
    /**
     * Calculate course progress details for a user
     */
    public function calculateCourseProgress(Course $course, int $userId)
    {
        $totalSections = $course->courseSections->count();
        $totalContents = $course->courseSections->flatMap->sectionContents->count();
        
        if ($totalContents === 0) {
            return [
                'percent' => 0,
                'completed_contents' => 0,
                'total_contents' => 0,
                'completed_sections' => 0,
                'total_sections' => $totalSections,
            ];
        }
        
        $completedContentIds = $this->getCompletedContentIds($userId, $course->id);
        $completedContents = count($completedContentIds);
        
        // Count completed sections
        $completedSections = 0;
        foreach ($course->courseSections as $section) {
            $sectionContentIds = $section->sectionContents->pluck('id')->toArray();
            if (!empty($sectionContentIds)) {
                $completedSectionContentIds = array_intersect($sectionContentIds, $completedContentIds);
                if (count($completedSectionContentIds) === count($sectionContentIds)) {
                    $completedSections++;
                }
            }
        }
        
        return [
            'percent' => $totalContents > 0 ? round(($completedContents / $totalContents) * 100) : 0,
            'completed_contents' => $completedContents,
            'total_contents' => $totalContents,
            'completed_sections' => $completedSections,
            'total_sections' => $totalSections,
        ];
    }
}