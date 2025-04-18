@extends('front.layouts.app')

@section('title', $quiz->title . ' - Dialogika Public Speaking Online Course')

@section('content')
    <x-navigation-auth />
    <main class="flex flex-1 items-center justify-center py-5">
        <div class="w-[1000px] !h-fit rounded-[20px] border border-obito-grey bg-white shadow-[0px_10px_30px_0px_#B8B8B840] overflow-hidden">
            <div class="w-full p-5">
                <h1 class="font-bold text-[22px] leading-[33px] text-center">{{ $quiz->title }}</h1>

                @if ($userQuiz && $userQuiz->is_completed)
                    <div class="p-5 mt-1 mb-5 bg-obito-light-green border border-obito-green rounded-[14px] text-center">
                        <p class="font-bold text-obito-green text-[18px] leading-[27px] flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Quiz sudah dikerjakan. Skor Anda: {{ $score ?? 'N/A' }}/{{ $totalScore ?? 'N/A' }}
                        </p>
                    </div>

                    @if ($nextContent)
                        <a href="{{ route('dashboard.course.learning', [
                            'course' => $quiz->courseSection->course->slug,
                            'courseSection' => $nextContent->course_section_id,
                            'sectionContent' => $nextContent->id,
                        ]) }}" class="w-full py-3 mt-6 mb-5 bg-obito-green text-white font-semibold rounded-[14px] hover:drop-shadow-effect transition-all duration-300 text-center block border border-obito-green flex items-center justify-center gap-2">
                            <span>Lanjutkan Pembelajaran Selanjutnya</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    @else
                        <p class="mt-4 text-center text-obito-text-secondary">
                            Tidak ada pembelajaran selanjutnya.
                        </p>
                    @endif
                @endif

                @if($reviewMode)
                    <div class="review-header bg-[#F8FAF9] p-4 rounded-[14px] mb-5 mt-5 border border-obito-grey">
                        <h3 class="font-semibold text-lg flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-obito-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Quiz Review
                        </h3>
                        <div class="flex items-center justify-between mt-2">
                            <p class="text-sm text-obito-text-secondary">
                                You scored {{ $score }}% on this quiz
                            </p>
                            <span class="font-semibold py-1 px-3 text-sm rounded-full {{ $score >= 70 ? 'bg-obito-light-green text-obito-green' : 'bg-obito-light-red text-obito-red' }}">
                                {{ $score >= 70 ? 'Passed' : 'Failed' }}
                            </span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('quizzes.submit', $quiz) }}" method="POST" class="flex flex-col gap-6 mt-6">
                    @csrf
                    @foreach ($quiz->questions as $index => $question)
                        <div class="flex flex-col gap-4 mt-6 p-5 mb-5 border border-obito-grey rounded-[14px] bg-[#F8FAF9] hover:border-obito-green transition-all duration-300">
                            <p class="font-semibold text-[18px] leading-[27px] flex items-center gap-2">
                                <span class="flex items-center justify-center bg-obito-green text-white w-6 h-6 rounded-full text-sm">{{ $index + 1 }}</span>
                                {{ $question->question }}
                            </p>
                            <div class="flex flex-col gap-2">
                                @foreach ($question->options as $option)
                                    <label class="flex items-center gap-3 p-3 border {{ isset($userQuiz->answers[$question->id]) && $userQuiz->answers[$question->id] === $option ? ($option == $question->correct_answer ? 'border-obito-green bg-obito-light-green' : 'border-obito-red bg-obito-light-red') : 'border-obito-grey' }} rounded-[10px] hover:border-obito-green transition-all duration-300">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" class="accent-obito-green"
                                            @if ($userQuiz && $userQuiz->answers && isset($userQuiz->answers[$question->id]) && $userQuiz->answers[$question->id] === $option) checked @endif
                                            @if ($userQuiz && $userQuiz->is_completed) disabled @endif>
                                        <span class="{{ isset($userQuiz->answers[$question->id]) && $userQuiz->answers[$question->id] === $option ? ($option == $question->correct_answer ? 'text-obito-green font-semibold' : 'text-obito-red') : 'text-obito-text-secondary' }}">
                                            {{ $option }}
                                            @if($reviewMode && isset($userQuiz->answers[$question->id]) && $userQuiz->answers[$question->id] === $option)
                                                @if($option == $question->correct_answer)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-1 h-1 inline-block ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-1 h-1 inline-block ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                @endif
                                            @endif
                                        </span>
                                    </label>
                                @endforeach
                            </div>

                            @if($reviewMode)
                                <div class="answer-review mt-2 pt-2 border-t border-obito-grey">
                                    <div class="flex gap-2 items-start">
                                        @if(isset($userQuiz->answers[$question->id]) && $userQuiz->answers[$question->id] == $question->correct_answer)
                                            <div class="bg-obito-light-green rounded-full p-0.5 flex items-center justify-center w-4 h-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 text-obito-green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <p class="text-sm text-obito-text-secondary">
                                                <span class="font-semibold text-obito-green">Correct!</span> Your answer: 
                                                <span class="font-semibold">{{ $userQuiz->answers[$question->id] ?? 'Not answered' }}</span>
                                            </p>
                                        @else
                                            <div class="bg-obito-light-red rounded-full p-0.5 flex items-center justify-center w-4 h-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-2.5 h-2.5 text-obito-red" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </div>
                                            <div class="text-sm">
                                                <p class="text-obito-text-secondary">
                                                    <span class="font-semibold text-obito-red">Incorrect.</span> Your answer: 
                                                    <span class="font-semibold">{{ $userQuiz->answers[$question->id] ?? 'Not answered' }}</span>
                                                </p>
                                                <p class="text-obito-text-secondary mt-1">
                                                    <span class="font-semibold text-obito-green">Correct answer:</span> {{ $question->correct_answer }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    @if (!$userQuiz || !$userQuiz->is_completed)
                        <button type="submit" class="w-full py-3 mt-6 bg-obito-green text-white font-semibold rounded-[14px] hover:drop-shadow-effect transition-all duration-300 border border-obito-green flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Submit Quiz
                        </button>
                    @endif
                </form>
            </div>
        </div>
    </main>
@endsection