@extends('front.layouts.app')

@section('title', $quiz->title . ' - Dialogika Public Speaking Online Course')

@section('content')
    <x-navigation-auth />
    <main class="flex flex-1 items-center justify-center py-5">
        <div class="flex w-[1000px] !h-fit rounded-[20px] border border-obito-grey gap-[40px] bg-white items-center p-5">
            <div id="quiz-container" class="w-full flex flex-col gap-5">
                <h1 class="font-bold text-[22px] leading-[33px] text-center">{{ $quiz->title }}</h1>

                @if ($userQuiz && $userQuiz->is_completed)
                    <div class="p-4 bg-obito-light-green border border-obito-green rounded-[14px] text-center mb-6">
                        <p class="font-bold text-obito-green text-[18px] leading-[27px]">
                            Quiz sudah dikerjakan. Skor Anda: {{ $score ?? 'N/A' }}/{{ $totalScore ?? 'N/A' }}
                        </p>
                    </div>

                    @if ($nextContent)
                        <a href="{{ route('dashboard.course.learning', [
                            'course' => $quiz->courseSection->course->slug,
                            'courseSection' => $nextContent->course_section_id,
                            'sectionContent' => $nextContent->id,
                        ]) }}" class="w-full py-3 mt-6 bg-obito-green text-white font-semibold rounded-[14px] hover:drop-shadow-effect transition-all duration-300 text-center block border border-obito-green mb-5">
                            Lanjutkan Pembelajaran Selanjutnya
                        </a>
                    @else
                        <p class="mt-4 text-center text-obito-text-secondary">
                            Tidak ada pembelajaran selanjutnya.
                        </p>
                    @endif
                @endif

                <form action="{{ route('quizzes.submit', $quiz) }}" method="POST" class="flex flex-col gap-6 mt-6">
                    @csrf
                    @foreach ($quiz->questions as $index => $question)
                        <div class="flex flex-col gap-6 mt-[30px]"> <!-- Tambahkan gap-6 untuk jarak antar pertanyaan -->
                            <p class="font-semibold text-[18px] leading-[27px]">
                                {{ $index + 1 }}. {{ $question->question }}
                            </p>
                            <div class="flex flex-col gap-2">
                                @foreach ($question->options as $option)
                                    <label class="flex items-center gap-3 p-3 border border-obito-grey rounded-[10px] hover:border-obito-green transition-all duration-300">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" class="accent-obito-green"
                                            @if ($userQuiz && $userQuiz->answers && isset($userQuiz->answers[$question->id]) && $userQuiz->answers[$question->id] === $option) checked @endif
                                            @if ($userQuiz && $userQuiz->is_completed) disabled @endif>
                                        <span class="text-obito-text-secondary">{{ $option }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    @if (!$userQuiz || !$userQuiz->is_completed)
                        <button type="submit" class="w-full py-3 mt-[30px] bg-obito-green text-white font-semibold rounded-[14px] hover:drop-shadow-effect transition-all duration-300 border border-obito-green">
                            Submit
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </main>
@endsection