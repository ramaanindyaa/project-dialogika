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
        $reviewMode = false;

        if ($userQuiz && $userQuiz->is_completed) {
            $score = session('score') ?? $userQuiz->score;
            $totalScore = session('totalScore') ?? $quiz->questions->count() * 20;
            $reviewMode = true; // Enable review mode
        }

        // Cari section dan content selanjutnya
        $currentSection = $quiz->courseSection;
        $currentContent = $currentSection->sectionContents->first(); // Ambil content pertama dari section ini
        $nextContent = null;

        // Cari content selanjutnya di section yang sama
        if ($currentContent) {
            $nextContent = $currentSection->sectionContents
                ->where('id', '>', $currentContent->id)
                ->sortBy('id')
                ->first();
        }

        // Jika tidak ada content selanjutnya, cari di section berikutnya
        if (!$nextContent) {
            $nextSection = $quiz->courseSection->course->courseSections
                ->where('id', '>', $currentSection->id)
                ->sortBy('id')
                ->first();

            if ($nextSection) {
                $nextContent = $nextSection->sectionContents->sortBy('id')->first();
            }
        }

        return view('quizzes.show', compact('quiz', 'userQuiz', 'score', 'totalScore', 'nextContent', 'reviewMode'));
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

    public function history()
    {
        // Get the authenticated user
        $user = auth()->user();
        
        // Get all completed quizzes for the user
        $completedQuizzes = UserQuiz::where('user_id', $user->id)
            ->where('is_completed', true)
            ->with(['quiz.courseSection.course', 'quiz.questions'])
            ->latest()
            ->get();
        
        // Group quizzes by course for better organization
        $quizzesByCourse = $completedQuizzes->groupBy('quiz.courseSection.course.name');
        
        return view('quizzes.history', compact('quizzesByCourse'));
    }
}
