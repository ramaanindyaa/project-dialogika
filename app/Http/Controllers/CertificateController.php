<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function downloadCertificate(Course $course)
    {
        $user = Auth::user();

        // Validasi apakah user telah menyelesaikan course
        if (!$course->courseStudents()->where('user_id', $user->id)->where('is_active', true)->exists()) {
            abort(403, 'You have not completed this course.');
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
