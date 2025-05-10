@extends('front.layouts.app')
@section('title', 'Learning Progress - ' . $course->name . ' - Dialogika')
@section('content')
<div class="flex flex-col gap-10 pb-10 mt-[30px]">
    <section class="flex flex-col w-full max-w-[1280px] px-[75px] gap-4 mx-auto">
        <!-- Header Section -->
        <div class="flex items-center justify-between mb-4">
            <div class="flex flex-col gap-2">
                <h1 class="font-bold text-[28px] leading-[42px]">Learning Progress</h1>
                <h2 class="text-lg text-obito-text-secondary">{{ $course->name }}</h2>
            </div>
            <a href="{{ route('dashboard.course.details', $course->slug) }}" class="back-link hover:border-obito-green transition-all duration-300">
                <img src="{{ asset('assets/images/icons/back.svg') }}" class="w-5 h-5" alt="back">
                <span class="font-semibold">Back to Course Details</span>
            </a>
        </div>
        
        <!-- Progress Overview Card -->
        <div class="progress-container mt-6 rounded-[20px] hover:shadow-[0px_10px_30px_0px_#B8B8B840] transition-all duration-300">
            <div class="progress-header flex items-center justify-between">
                <div>
                    <h3 class="progress-title font-bold text-[22px] leading-[33px]">Overall Progress</h3>
                    <p class="progress-subtitle text-sm mt-2">
                        {{ $progress['completed_contents'] }} of {{ $progress['total_contents'] }} lessons completed
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center bg-[#F8FAF9] w-[90px] h-[90px] rounded-full border-4 border-obito-green relative">
                        <span class="text-[28px] font-bold">{{ $progress['percent'] }}%</span>
                    </div>
                    @if($progress['percent'] == 100)
                        <span class="completed-badge text-sm">Completed</span>
                    @endif
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="progress-bar-container h-3 rounded-full mt-6 mb-6 overflow-hidden">
                <div class="progress-bar h-full" style="width: {{ $progress['percent'] }}%; --progress-width: {{ $progress['percent'] }}%;"></div>
            </div>
            
            <!-- Progress Stats -->
            <div class="progress-stats grid grid-cols-3 gap-4 mt-8">
                <div class="progress-stat-card hover:border-obito-green transition-all duration-300">
                    <div class="flex gap-4 items-center">
                        <div class="flex items-center justify-center w-12 h-12 bg-obito-light-green rounded-full shrink-0">
                            <img src="{{ asset('assets/images/icons/note-favorite-green.svg') }}" class="w-6 h-6" alt="sections">
                        </div>
                        <div>
                            <p class="progress-stat-label font-medium">Completed Sections</p>
                            <p class="progress-stat-value font-bold">
                                {{ $progress['completed_sections'] }}/{{ $progress['total_sections'] }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="progress-stat-card hover:border-obito-green transition-all duration-300">
                    <div class="flex gap-4 items-center">
                        <div class="flex items-center justify-center w-12 h-12 bg-obito-light-green rounded-full shrink-0">
                            <img src="{{ asset('assets/images/icons/menu-board-green.svg') }}" class="w-6 h-6" alt="lessons">
                        </div>
                        <div>
                            <p class="progress-stat-label font-medium">Completed Lessons</p>
                            <p class="progress-stat-value font-bold">
                                {{ $progress['completed_contents'] }}/{{ $progress['total_contents'] }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="progress-stat-card hover:border-obito-green transition-all duration-300">
                    <div class="flex gap-4 items-center">
                        <div class="flex items-center justify-center w-12 h-12 bg-obito-light-green rounded-full shrink-0">
                            <img src="{{ asset('assets/images/icons/buildings-green-fill.svg') }}" class="w-6 h-6" alt="progress">
                        </div>
                        <div>
                            <p class="progress-stat-label font-medium">Progress</p>
                            <p class="progress-stat-value font-bold">{{ $progress['percent'] }}%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Course Progress Details -->
        <div class="mt-10">
            <h3 class="font-bold text-[22px] leading-[33px] mb-6">Course Progress Details</h3>
            
            @foreach($course->courseSections as $section)
                <div class="progress-section mb-5 rounded-[14px] hover:border-obito-green transition-all duration-300">
                    <div class="progress-section-header rounded-t-[14px]">
                        <h4 class="progress-section-title font-semibold text-lg">{{ $section->name }}</h4>
                        @php
                            $sectionContentCount = $section->sectionContents->count();
                            $completedInSection = $section->sectionContents
                                ->filter(function($content) {
                                    return $content->isCompletedByUser();
                                })
                                ->count();
                            
                            $sectionPercentage = $sectionContentCount > 0 
                                ? round(($completedInSection / $sectionContentCount) * 100) 
                                : 0;
                        @endphp
                        <div class="progress-section-stats">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold">{{ $completedInSection }}/{{ $sectionContentCount }}</span>
                                <div class="w-[75px] h-1.5 bg-obito-grey rounded-full overflow-hidden">
                                    <div class="bg-obito-green h-full" style="width: {{ $sectionPercentage }}%"></div>
                                </div>
                                <span>{{ $sectionPercentage }}%</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="progress-section-content">
                        @foreach($section->sectionContents as $content)
                            <div class="progress-item hover:bg-[rgba(47,106,98,0.03)] transition-all duration-300 rounded-[14px] py-3 px-4">
                                <div class="progress-item-left">
                                    @if($content->isCompletedByUser())
                                        <div class="progress-check progress-check-complete">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 3L4.5 8.5L2 6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    @else
                                        <div class="progress-check progress-check-incomplete"></div>
                                    @endif
                                    <span class="font-medium">{{ $content->name }}</span>
                                </div>
                                <a href="{{ route('dashboard.course.learning', [
                                    'course' => $course->slug,
                                    'courseSection' => $section->id,
                                    'sectionContent' => $content->id,
                                ]) }}" class="progress-action-link hover:bg-[rgba(47,106,98,0.1)] transition-all duration-300">
                                    {{ $content->isCompletedByUser() ? 'Review' : 'Start' }}
                                </a>
                            </div>
                        @endforeach
                        
                        @if($section->quizzes->isNotEmpty())
                            @foreach($section->quizzes as $quiz)
                                <div class="progress-item hover:bg-[rgba(47,106,98,0.03)] transition-all duration-300 rounded-[14px] py-3 px-4">
                                    <div class="progress-item-left">
                                        @php
                                            $isQuizCompleted = auth()->user()->userQuizzes
                                                ->where('quiz_id', $quiz->id)
                                                ->where('is_completed', true)
                                                ->isNotEmpty();
                                        @endphp
                                        
                                        @if($isQuizCompleted)
                                            <div class="progress-check progress-check-complete">
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M10 3L4.5 8.5L2 6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                        @else
                                            <div class="progress-check progress-check-incomplete">
                                                <img src="{{ asset('assets/images/icons/message-programming.svg') }}" class="w-3 h-3 opacity-50" alt="quiz">
                                            </div>
                                        @endif
                                        <div>
                                            <span class="font-medium">{{ $quiz->title }}</span>
                                            <span class="text-xs text-obito-text-secondary ml-2">({{ ucfirst($quiz->type) }} Quiz)</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('quizzes.show', $quiz) }}" class="progress-action-link bg-{{ $isQuizCompleted ? 'white' : 'obito-light-green' }} hover:bg-[rgba(47,106,98,0.1)] transition-all duration-300">
                                        {{ $isQuizCompleted ? 'Review Quiz' : 'Take Quiz' }}
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
            
            <!-- Course Completion Message -->
            @if($progress['percent'] == 100)
            <div class="mt-8 p-6 bg-white border border-obito-green rounded-[20px] flex gap-6 items-center">
                <div class="flex items-center justify-center w-16 h-16 bg-obito-light-green rounded-full shrink-0">
                    <img src="{{ asset('assets/images/icons/cup-green-fill.svg') }}" class="w-8 h-8" alt="completed">
                </div>
                <div>
                    <h4 class="font-bold text-lg">Congratulations! You've completed this course.</h4>
                    <p class="text-obito-text-secondary mt-1">You can now download your certificate or explore other courses.</p>
                </div>
                <a href="{{ route('courses.certificate', $course) }}" class="ml-auto text-white rounded-full py-[10px] px-5 gap-[10px] bg-obito-green hover:drop-shadow-effect transition-all duration-300">
                    <span class="font-semibold">Get Certificate</span>
                </a>
            </div>
            <div class="mt-8 p-6 bg-white border border-obito-green rounded-[20px] flex gap-6 items-center">
                <div class="flex items-center justify-center w-16 h-16 bg-obito-light-green rounded-full shrink-0">
                    <img src="{{ asset('assets/images/icons/cup-green-fill.svg') }}" class="w-8 h-8" alt="completed">
                </div>
                <div class="flex-grow">
                    <h4 class="font-bold text-lg">Congratulations! You've completed this course.</h4>
                    <p class="text-obito-text-secondary mt-1">You can now showcase your skills by creating a portfolio for this course.</p>
                    
                    <div class="mt-4 flex gap-3">
                        <a href="{{ route('dashboard.certificates') }}" class="rounded-full py-2 px-5 border border-obito-grey hover:border-obito-green transition-all duration-300">
                            <span class="font-semibold">View Certificate</span>
                        </a>
                        <a href="{{ route('dashboard.portfolios.create') }}?course_id={{ $course->id }}" class="text-white rounded-full py-2 px-5 bg-obito-green hover:drop-shadow-effect transition-all duration-300">
                            <span class="font-semibold">Create Portfolio</span>
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
</div>
@endsection