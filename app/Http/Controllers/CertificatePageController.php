<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\LearningProgress;
use App\Services\LearningProgressService;
use Illuminate\Support\Facades\Auth;

class CertificatePageController extends Controller
{
    protected $learningProgressService;
    
    public function __construct(LearningProgressService $learningProgressService)
    {
        $this->learningProgressService = $learningProgressService;
    }
    
    public function index()
    {
        $user = Auth::user();
        
        // Only get courses that the user has 100% completed
        $enrolledCourses = Course::whereHas('courseStudents', function($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('is_active', true);
        })->get();
        
        // Filter courses to only show completed ones
        $completedCourses = collect();
        
        foreach ($enrolledCourses as $course) {
            $progress = $this->learningProgressService->calculateCourseProgress($course, $user->id);
            
            if ($progress['percent'] == 100) {
                $completedCourses->push($course);
            }
        }
        
        return view('certificates.index', compact('completedCourses'));
    }
    
    public function viewCertificate(Course $course)
    {
        $user = Auth::user();
        
        // Calculate progress to validate if course is completed
        $progress = $this->learningProgressService->calculateCourseProgress($course, $user->id);
        
        // Only allow viewing certificate if course is completed (100%)
        if ($progress['percent'] != 100) {
            return redirect()->route('dashboard.course.details', $course->slug)
                ->with('error', 'You need to complete this course to access the certificate.');
        }

        $mentorName = $course->courseMentors()->first()?->mentor->name ?? 'Instructor';
        
        // Data for certificate
        $data = [
            'userName' => $user->name,
            'courseName' => $course->name,
            'completionDate' => now()->format('d F Y'),
            'mentorName' => $mentorName,
            'course' => $course
        ];

        return view('certificates.preview', $data);
    }
}