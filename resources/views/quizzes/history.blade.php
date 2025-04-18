@extends('front.layouts.app')
@section('title', 'My Quizzes - Dialogika Public Speaking Online Course')
@section('content')
    <x-navigation-auth />
    <nav id="bottom-nav" class="flex w-full bg-white border-b border-obito-grey py-[14px]">
        <ul class="flex w-full max-w-[1280px] px-[75px] mx-auto gap-3">
            <li class="group">
                <a href="{{ route('dashboard.course.overview') }}"
                    class="flex items-center gap-2 rounded-full border border-obito-grey py-2 px-[14px] hover:border-obito-green bg-white transition-all duration-300 group-[.active]:bg-obito-light-green group-[.active]:border-obito-light-green">
                    <img src="{{ asset('assets/images/icons/home-trend-up.svg') }}" class="flex shrink-0 w-5" alt="icon">
                    <span>Overview</span>
                </a>
            </li>
            <li class="group">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-2 rounded-full border border-obito-grey py-2 px-[14px] hover:border-obito-green bg-white transition-all duration-300 group-[.active]:bg-obito-light-green group-[.active]:border-obito-light-green">
                    <img src="{{ asset('assets/images/icons/note-favorite.svg') }}" class="flex shrink-0 w-5" alt="icon">
                    <span>Courses</span>
                </a>
            </li>
            <li class="group active">
                <a href="{{ route('dashboard.quizzes.history') }}"
                    class="flex items-center gap-2 rounded-full border border-obito-grey py-2 px-[14px] hover:border-obito-green bg-white transition-all duration-300 group-[.active]:bg-obito-light-green group-[.active]:border-obito-light-green">
                    <img src="{{ asset('assets/images/icons/message-programming.svg') }}" class="flex shrink-0 w-5" alt="icon">
                    <span>Quizzes</span>
                </a>
            </li>
            <li class="group">
                <a href="{{ route('dashboard.certificates') }}"
                    class="flex items-center gap-2 rounded-full border border-obito-grey py-2 px-[14px] hover:border-obito-green bg-white transition-all duration-300 group-[.active]:bg-obito-light-green group-[.active]:border-obito-light-green">
                    <img src="{{ asset('assets/images/icons/cup.svg') }}" class="flex shrink-0 w-5" alt="icon">
                    <span>Certificates</span>
                </a>
            </li>
            <li class="group">
                <a href="#"
                    class="flex items-center gap-2 rounded-full border border-obito-grey py-2 px-[14px] hover:border-obito-green bg-white transition-all duration-300 group-[.active]:bg-obito-light-green group-[.active]:border-obito-light-green">
                    <img src="{{ asset('assets/images/icons/ruler&pen.svg') }}" class="flex shrink-0 w-5" alt="icon">
                    <span>Portfolios</span>
                </a>
            </li>
        </ul>
    </nav>
    
    <main class="flex flex-col gap-10 pb-10 mt-[30px]">
        <section class="flex flex-col w-full max-w-[1280px] px-[75px] gap-4 mx-auto">
            <h2 class="font-bold text-[22px] leading-[33px]">My Quizzes</h2>
            
            <!-- Quiz Stats -->
            <div class="progress-stats">
                <div class="progress-stat-card">
                    <div class="progress-stat-label">Total Quizzes Taken</div>
                    <div class="progress-stat-value">{{ $quizzesByCourse->flatten()->count() }}</div>
                </div>
                <div class="progress-stat-card">
                    <div class="progress-stat-label">Average Score</div>
                    <div class="progress-stat-value">
                        {{ round($quizzesByCourse->flatten()->avg('score')) }}%
                    </div>
                </div>
                <div class="progress-stat-card">
                    <div class="progress-stat-label">Courses with Quizzes</div>
                    <div class="progress-stat-value">{{ $quizzesByCourse->count() }}</div>
                </div>
            </div>
            
            <!-- Quizzes by Course -->
            @forelse($quizzesByCourse as $courseName => $quizzes)
                <div class="progress-section">
                    <div class="progress-section-header">
                        <div class="progress-section-title">{{ $courseName }}</div>
                        <div class="progress-section-stats">
                            <span>{{ $quizzes->count() }} quizzes</span>
                        </div>
                    </div>
                    
                    <div class="progress-section-content">
                        @foreach($quizzes as $userQuiz)
                            <div class="quiz-card p-4 border border-obito-grey rounded-[14px] mb-5 hover:border-obito-green transition-all duration-300">
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-3">
                                        <div class="quiz-icon bg-obito-light-green p-3 rounded-full">
                                            <img src="{{ asset('assets/images/icons/message-programming.svg') }}" class="w-6 h-6" alt="quiz">
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-lg">{{ $userQuiz->quiz->title }}</h3>
                                            <p class="text-sm text-obito-text-secondary">
                                                {{ $userQuiz->quiz->courseSection->name }} • 
                                                {{ $userQuiz->quiz->type === 'pre' ? 'Pre-Section' : 'Post-Section' }} Quiz
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="score-badge {{ $userQuiz->score >= 70 ? 'bg-obito-green' : 'bg-obito-light-red' }} px-4 py-2 rounded-full text-white">
                                        <span class="font-semibold">{{ $userQuiz->score }}%</span>
                                    </div>
                                </div>
                                
                                <div class="mt-4 pt-4 border-t border-obito-grey">
                                    <div class="flex justify-between items-center">
                                        <div class="text-sm text-obito-text-secondary">
                                            Completed on {{ $userQuiz->updated_at->format('d M Y, H:i') }}
                                        </div>
                                        
                                        <a href="{{ route('quizzes.show', $userQuiz->quiz) }}" class="progress-action-link flex items-center gap-2">
                                            <span>Review Quiz</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-10 bg-white rounded-[20px] border border-obito-grey">
                    <img src="{{ asset('assets/images/icons/message-programming.svg') }}" class="w-16 h-16 mb-4" alt="No quizzes">
                    <p class="text-lg font-semibold">You haven't completed any quizzes yet</p>
                    <p class="text-obito-text-secondary mt-1">Complete quizzes in your courses to see them here</p>
                    <a href="{{ route('dashboard') }}" class="mt-10 mb-5 px-5 py-3 bg-obito-green text-white rounded-full hover:drop-shadow-effect transition-all duration-300">
                        Browse Courses
                    </a>
                </div>
            @endforelse
        </section>
    </main>
@endsection