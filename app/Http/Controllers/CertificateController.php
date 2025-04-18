<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\LearningProgressService;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    protected $learningProgressService;
    
    public function __construct(LearningProgressService $learningProgressService)
    {
        $this->learningProgressService = $learningProgressService;
    }
    
    public function downloadCertificate(Course $course)
    {
        $user = Auth::user();
        
        // Calculate progress to validate if course is completed
        $progress = $this->learningProgressService->calculateCourseProgress($course, $user->id);
        
        // Only allow downloading certificate if course is completed (100%)
        if ($progress['percent'] != 100) {
            return redirect()->route('dashboard.course.details', $course->slug)
                ->with('error', 'You need to complete this course to download the certificate.');
        }

        $mentorName = $course->courseMentors()->first()?->mentor->name ?? 'Instructor';

        // Data untuk sertifikat
        $data = [
            'userName' => $user->name,
            'courseName' => $course->name,
            'completionDate' => now()->format('d F Y'),
            'mentorName' => $mentorName,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('certificates.template', $data);

        return $pdf->download("Certificate - {$course->name}.pdf");
    }
}
