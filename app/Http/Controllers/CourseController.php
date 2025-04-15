<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\CourseService;
use App\Services\LearningProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        // Calculate progress if user is logged in and enrolled
        if (auth()->check() && $course->isEnrolledByUser()) {
            // This uses the progress_percentage accessor you already have
            // Make sure to eager load learningProgress for better performance
            $course->loadCount([
                'learningProgress as completed_contents_count' => function ($query) {
                    $query->where('user_id', auth()->id())
                        ->where('is_completed', true);
                }
            ]);
            
            // Total content count
            $course->total_contents_count = $course->courseSections->flatMap->sectionContents->count();
        }
        
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

    /**
     * Display an overview of the student's course progress
     * 
     * @return \Illuminate\View\View
     */
    public function overview()
    {
        $user = Auth::user();
        
        // Get all courses the user is enrolled in
        $enrolledCourses = Course::whereHas('courseStudents', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['category', 'courseSections.sectionContents'])->get();
        
        // Get progress for each course
        $coursesWithProgress = [];
        foreach ($enrolledCourses as $course) {
            $progress = $this->learningProgressService->calculateCourseProgress($course, $user->id);
            $coursesWithProgress[] = [
                'course' => $course,
                'progress' => $progress
            ];
        }
        
        // Get the latest course the user was learning
        $latestProgress = \App\Models\LearningProgress::where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
            ->with(['course', 'courseSection', 'sectionContent'])
            ->first();
            
        $latestCourse = $latestProgress ? $latestProgress->course : null;
        
        return view('courses.overview', compact('coursesWithProgress', 'latestCourse'));
    }
}
