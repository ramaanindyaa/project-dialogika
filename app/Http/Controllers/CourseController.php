<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\CourseService;
use App\Services\LearningProgressService;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $courseService;
    protected $learningProgressService;

    public function __construct(
        CourseService $courseService,
        LearningProgressService $learningProgressService
    ) {
        $this->courseService = $courseService;
        $this->learningProgressService = $learningProgressService;
    }

    public function index()
    {
        $popularCourses = Course::where('is_popular', true)->get();
        $coursesByCategory = $this->courseService->getCoursesGroupedByCategory();

        return view('courses.index', compact('popularCourses', 'coursesByCategory'));
    }

    public function details(Course $course)
    {
        // eager loading
        $course->load([
            'category',
            'benefits',
            'courseSections.sectionContents',
            'courseMentors.mentor'
        ]);
        return view('courses.details', compact('course'));
    }

    public function join(Course $course)
    {
        $studentName = $this->courseService->enrollUser($course);
        $firstSectionAndContent = $this->courseService->getFirstSectionAndContent($course);

        return view('courses.success_joined', array_merge(
            compact('course', 'studentName'),
            $firstSectionAndContent
        ));
    }

    public function learning(Course $course, $courseSection, $sectionContent)
    {
        $currentSection = $course->courseSections()->findOrFail($courseSection);
        $currentContent = $currentSection->sectionContents()->findOrFail($sectionContent);
        
        // Get the next content or section
        $nextContent = $this->getNextContent($course, $currentSection, $currentContent);
        
        // Mark the current content as completed
        $this->learningProgressService->markContentAsCompleted($currentContent);
        
        // Get all completed content IDs for this user and course
        $completedContentIds = $this->learningProgressService->getCompletedContentIds(
            auth()->id(), 
            $course->id
        );
        
        // Check if this is the last content in the course
        $isFinished = $nextContent === null;
        
        return view('courses.learning', compact(
            'course', 
            'currentSection', 
            'currentContent', 
            'nextContent', 
            'isFinished',
            'completedContentIds'
        ));
    }
    
    // Helper method to find the next content
    private function getNextContent(Course $course, $currentSection, $currentContent)
    {
        // Try to find the next content in the same section
        $nextContent = $currentSection->sectionContents()
            ->where('id', '>', $currentContent->id)
            ->orderBy('id')
            ->first();
            
        // If not found, try to find the next section and its first content
        if (!$nextContent) {
            $nextSection = $course->courseSections()
                ->where('id', '>', $currentSection->id)
                ->orderBy('id')
                ->first();
                
            if ($nextSection) {
                $nextContent = $nextSection->sectionContents()
                    ->orderBy('id')
                    ->first();
            }
        }
        
        return $nextContent;
    }

    public function learning_finished(Course $course)
    {
        // Logic for when the course is finished
        return view('courses.learning_finished', compact('course'));
    }

    public function search_courses(Request $request)
    {
        $request->validate([
            'search' => 'required|string',
        ]);

        $keyword = $request->search;

        // Delegate the search logic to the service
        $courses = $this->courseService->searchCourses($keyword);

        return view('courses.search', compact('courses', 'keyword'));
    }

    // Add a new method for learning progress
    public function learningProgress(Course $course)
    {
        $progress = $this->learningProgressService->calculateCourseProgress(
            $course, 
            auth()->id()
        );
        
        return view('courses.learning_progress', compact('course', 'progress'));
    }
}
