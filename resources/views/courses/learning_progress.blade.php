@extends('front.layouts.app')
@section('title', 'Learning Progress - ' . $course->name . ' - Dialogika')
@section('content')
<div class="flex flex-col gap-10 pb-10 mt-[30px]">
    <section class="flex flex-col w-full max-w-[1280px] px-[75px] gap-4 mx-auto">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="font-bold text-2xl">Learning Progress</h1>
                <h2 class="text-lg text-obito-text-secondary">{{ $course->name }}</h2>
            </div>
            <a href="{{ route('dashboard.course.details', $course->slug) }}" class="back-link">
                <img src="{{ asset('assets/images/icons/arrow-left.svg') }}" class="w-5 h-5" alt="back">
                <span>Back to Course Details</span>
            </a>
        </div>
        
        <div class="progress-container mt-6">
            <div class="progress-header">
                <div>
                    <h3 class="progress-title">Overall Progress</h3>
                    <p class="progress-subtitle">
                        {{ $progress['completed_contents'] }} of {{ $progress['total_contents'] }} lessons completed
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-2xl font-bold">{{ $progress['percent'] }}%</span>
                    @if($progress['percent'] == 100)
                        <span class="completed-badge">Completed</span>
                    @endif
                </div>
            </div>
            
            <div class="progress-bar-container">
                <div class="progress-bar" style="width: {{ $progress['percent'] }}%"></div>
            </div>
            
            <div class="progress-stats">
                <div class="progress-stat-card">
                    <p class="progress-stat-label">Completed Sections</p>
                    <p class="progress-stat-value">
                        {{ $progress['completed_sections'] }}/{{ $progress['total_sections'] }}
                    </p>
                </div>
                <div class="progress-stat-card">
                    <p class="progress-stat-label">Completed Lessons</p>
                    <p class="progress-stat-value">
                        {{ $progress['completed_contents'] }}/{{ $progress['total_contents'] }}
                    </p>
                </div>
                <div class="progress-stat-card">
                    <p class="progress-stat-label">Progress</p>
                    <p class="progress-stat-value">{{ $progress['percent'] }}%</p>
                </div>
            </div>
        </div>
        
        <div class="mt-8">
            <h3 class="font-bold text-xl mb-4">Course Progress Details</h3>
            
            @foreach($course->courseSections as $section)
                <div class="progress-section mb-4">
                    <div class="progress-section-header">
                        <h4 class="progress-section-title">{{ $section->name }}</h4>
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
                            <span>{{ $completedInSection }}/{{ $sectionContentCount }}</span>
                            <span>{{ $sectionPercentage }}%</span>
                        </div>
                    </div>
                    
                    <div class="progress-section-content">
                        @foreach($section->sectionContents as $content)
                            <div class="progress-item">
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
                                    <span>{{ $content->name }}</span>
                                </div>
                                <a href="{{ route('dashboard.course.learning', [
                                    'course' => $course->slug,
                                    'courseSection' => $section->id,
                                    'sectionContent' => $content->id,
                                ]) }}" class="progress-action-link">
                                    {{ $content->isCompletedByUser() ? 'Review' : 'Start' }}
                                </a>
                            </div>
                        @endforeach
                        
                        @if($section->quizzes->isNotEmpty())
                            @foreach($section->quizzes as $quiz)
                                <div class="progress-item">
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
                                            <div class="progress-check progress-check-incomplete"></div>
                                        @endif
                                        <span>{{ $quiz->title }} ({{ ucfirst($quiz->type) }} Quiz)</span>
                                    </div>
                                    <a href="{{ route('quizzes.show', $quiz) }}" class="progress-action-link">
                                        {{ $isQuizCompleted ? 'Review Quiz' : 'Take Quiz' }}
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</div>
@endsection