@extends('front.layouts.app')

@section('title', $quiz->title . ' - Dialogika Public Speaking Online Course')

@section('content')
    <x-navigation-auth />
    <main class="flex flex-1 items-center justify-center py-5">
        <div class="flex w-[1000px] !h-fit rounded-[20px] border border-obito-grey gap-[40px] bg-white items-center p-5">
            <div id="quiz-container" class="w-full flex flex-col gap-5">
                <h1 class="font-bold text-[22px] leading-[33px] text-center">{{ $quiz->title }}</h1>
                <form action="{{ route('quizzes.submit', $quiz) }}" method="POST" class="flex flex-col gap-6">
                    @csrf
                    @foreach ($quiz->questions as $index => $question)
                        <div class="flex flex-col gap-4">
                            <p class="font-semibold text-[18px] leading-[27px]">
                                {{ $index + 1 }}. {{ $question->question }}
                            </p>
                            <div class="flex flex-col gap-2">
                                @foreach ($question->options as $option)
                                    <label class="flex items-center gap-3 p-3 border border-obito-grey rounded-[10px] hover:border-obito-green transition-all duration-300">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" class="accent-obito-green">
                                        <span class="text-obito-text-secondary">{{ $option }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    <button type="submit" class="w-full py-3 mt-6 bg-obito-green text-white font-semibold rounded-[10px] hover:drop-shadow-effect transition-all duration-300">
                        Submit
                    </button>
                </form>
                @if (session('score'))
                    <div class="mt-6 p-4 bg-obito-light-green border border-obito-green rounded-[10px] text-center">
                        <p class="font-bold text-obito-green text-[18px] leading-[27px]">
                            Your score: {{ session('score') }}/{{ session('totalScore') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection