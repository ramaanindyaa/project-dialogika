<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function show(Quiz $quiz)
    {
        return view('quizzes.show', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $score = 0;
        $totalQuestions = $quiz->questions->count();
        $pointsPerQuestion = 20; // Nilai default per pertanyaan

        foreach ($quiz->questions as $question) {
            if ($request->input("answers.{$question->id}") === $question->correct_answer) {
                $score += $pointsPerQuestion;
            }
        }

        return redirect()->back()->with([
            'score' => $score,
            'totalScore' => $totalQuestions * $pointsPerQuestion, // Total skor maksimal
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|string',
            'options' => 'required|array', // Pastikan options adalah array
            'correct_answer' => 'required|string',
        ]);

        $validated['options'] = json_encode($validated['options']); // Ubah array menjadi JSON

        QuizQuestion::create($validated);

        return redirect()->back()->with('success', 'Quiz question added successfully!');
    }
}
