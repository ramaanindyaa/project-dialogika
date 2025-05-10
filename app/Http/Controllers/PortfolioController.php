<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::with('course')->where('user_id', auth()->id())->get();
        
        return view('portfolios.index', compact('portfolios'));
    }

    public function create(Request $request)
    {
        $selectedCourseId = $request->query('course_id');
        
        // Get ONLY 100% completed courses
        $completedCourses = Course::whereHas('learningProgress', function($query) {
            $query->where('user_id', auth()->id())
                  ->where('is_completed', true);
        })->get()
        ->filter(function($course) {
            // Double check that the course is actually 100% complete
            return $course->progress_percentage == 100;
        });
        
        return view('portfolios.create', compact('completedCourses', 'selectedCourseId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'nullable|url',
            'course_id' => 'required|exists:courses,id',
            'image' => 'required|image|max:2048', // Max 2MB
        ]);

        // Verify that the course is actually 100% complete
        $course = Course::findOrFail($request->course_id);
        if ($course->progress_percentage < 100) {
            return redirect()->back()->with('error', 'You can only create portfolios for courses you have completed 100%');
        }

        $imagePath = $request->file('image')->store('portfolios', 'public');

        Portfolio::create([
            'name' => $request->name,
            'description' => $request->description,
            'url' => $request->url,
            'course_id' => $request->course_id,
            'user_id' => auth()->id(),
            'image' => $imagePath,
            'slug' => Str::slug($request->name) . '-' . Str::random(8),
        ]);

        return redirect()->route('dashboard.portfolios')->with('success', 'Portfolio successfully created!');
    }

    public function show($slug)
    {
        $portfolio = Portfolio::where('slug', $slug)->firstOrFail();
        
        return view('portfolios.show', compact('portfolio'));
    }
}