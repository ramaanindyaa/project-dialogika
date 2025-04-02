<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\UserQuiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function show(Quiz $quiz)
    {
        $userQuiz = UserQuiz::where('user_id', auth()->id())
            ->where('quiz_id', $quiz->id)
            ->first();

        $score = null;
        $totalScore = null;

        if ($userQuiz && $userQuiz->is_completed) {
            $score = session('score') ?? $userQuiz->score; // Ambil skor dari session atau database
            $totalScore = session('totalScore') ?? $quiz->questions->count() * 20; // Hitung total skor
        }

        return view('quizzes.show', compact('quiz', 'userQuiz', 'score', 'totalScore'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $score = 0;
        $totalQuestions = $quiz->questions->count();
        $pointsPerQuestion = 20;

        $submittedAnswers = $request->input('answers', []);

        foreach ($quiz->questions as $question) {
            if (isset($submittedAnswers[$question->id]) && $submittedAnswers[$question->id] === $question->correct_answer) {
                $score += $pointsPerQuestion;
            }
        }

        // Simpan jawaban pengguna dan skor ke database
        UserQuiz::updateOrCreate(
            ['user_id' => auth()->id(), 'quiz_id' => $quiz->id],
            [
                'is_completed' => true,
                'answers' => $submittedAnswers,
                'score' => $score, // Simpan skor
            ]
        );

        return redirect()->route('quizzes.show', $quiz)->with([
            'score' => $score,
            'totalScore' => $totalQuestions * $pointsPerQuestion,
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
