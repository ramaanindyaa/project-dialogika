@extends('front.layouts.app')
@section('title', 'My Learning Overview - Dialogika Public Speaking Online Course')
@section('content')
    <x-navigation-auth />
    <nav id="bottom-nav" class="flex w-full bg-white border-b border-obito-grey py-[14px]">
        <ul class="flex w-full max-w-[1280px] px-[75px] mx-auto gap-3">
            <li class="group active">
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
            <li class="group">
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
        <!-- Latest Course Section -->
        @if($latestCourse)
        <section class="flex flex-col w-full max-w-[1280px] px-[75px] gap-4 mx-auto">
            <h2 class="font-bold text-[22px] leading-[33px]">Continue Learning</h2>
            <div class="grid grid-cols-1 gap-5">
                <div class="roadmap-card flex items-center rounded-[20px] border border-obito-grey p-[10px] pr-4 gap-4 bg-white hover:border-obito-green transition-all duration-300">
                    <div class="relative flex shrink-0 w-[240px] h-[150px] rounded-[14px] overflow-hidden bg-obito-grey">
                        <img src="{{ Storage::url($latestCourse->thumbnail) }}" class="w-full h-full object-cover" alt="thumbnail">
                        <p class="absolute flex m-[10px] bottom-0 w-[calc(100%-20px)] items-center gap-0.5 bg-white rounded-[14px] py-[6px] px-2">
                            <img src="{{ asset('assets/images/icons/play-circle-fill.svg') }}" class="flex shrink-0 w-5" alt="icon">
                            <span class="font-semibold text-xs leading-[18px]">Continue where you left off</span>
                        </p>
                    </div>
                    <div class="flex flex-col gap-3">
                        <h3 class="font-bold text-lg line-clamp-2">{{ $latestCourse->name }}</h3>
                        <p class="flex items-center gap-[6px]">
                            <img src="{{ asset('assets/images/icons/crown-green.svg') }}" class="flex shrink-0 w-5" alt="icon">
                            <span class="text-sm text-obito-text-secondary">{{ $latestCourse->category->name }}</span>
                        </p>
                        
                        <!-- Progress Bar -->
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: {{ $latestCourse->progress_percentage }}%;"></div>
                        </div>
                        <p class="text-sm text-obito-text-secondary">{{ $latestCourse->progress_percentage }}% completed</p>
                        
                        <a href="{{ route('dashboard.course.learning.progress', $latestCourse->slug) }}" 
                           class="flex items-center justify-center w-fit mt-2 rounded-full bg-obito-green text-white py-2 px-5 hover:drop-shadow-effect transition-all duration-300">
                            Continue Learning
                        </a>
                    </div>
                </div>
            </div>
        </section>
        @endif
        
        <!-- My Learning Progress Section -->
        <section class="flex flex-col w-full max-w-[1280px] px-[75px] gap-4 mx-auto">
            <h2 class="font-bold text-[22px] leading-[33px]">My Learning Progress</h2>
            
            <!-- Progress Stats Cards -->
            <div class="progress-stats">
                <div class="progress-stat-card">
                    <div class="progress-stat-label">Enrolled Courses</div>
                    <div class="progress-stat-value">{{ count($coursesWithProgress) }}</div>
                </div>
                <div class="progress-stat-card">
                    <div class="progress-stat-label">In Progress</div>
                    <div class="progress-stat-value">{{ count(array_filter($coursesWithProgress, function($item) { 
                        return $item['progress']['percent'] > 0 && $item['progress']['percent'] < 100; 
                    })) }}</div>
                </div>
                <div class="progress-stat-card">
                    <div class="progress-stat-label">Completed</div>
                    <div class="progress-stat-value">{{ count(array_filter($coursesWithProgress, function($item) { 
                        return $item['progress']['percent'] == 100; 
                    })) }}</div>
                </div>
            </div>
            
            <!-- Course Progress List -->
            <div class="mt-6">
                @forelse($coursesWithProgress as $item)
                <div class="progress-section">
                    <div class="progress-section-header">
                        <div class="progress-section-title">{{ $item['course']->name }}</div>
                        <div class="progress-section-stats">
                            <span>{{ $item['progress']['completed_contents'] }}/{{ $item['progress']['total_contents'] }} lessons</span>
                            <span>{{ $item['progress']['percent'] }}%</span>
                        </div>
                    </div>
                    
                    <div class="p-5">
                        <div class="flex items-center gap-3">
                            <div class="relative flex shrink-0 w-[75px] h-[75px] rounded-[14px] overflow-hidden bg-obito-grey">
                                <img src="{{ Storage::url($item['course']->thumbnail) }}" class="w-full h-full object-cover" alt="thumbnail">
                            </div>
                            
                            <div class="flex-1">
                                <p class="flex items-center gap-[6px] mb-5">
                                    <img src="{{ asset('assets/images/icons/crown-green.svg') }}" class="flex shrink-0 w-5" alt="icon">
                                    <span class="text-sm text-obito-text-secondary">{{ $item['course']->category->name }}</span>
                                    
                                    <span class="mx-2">•</span>
                                    
                                    <img src="{{ asset('assets/images/icons/briefcase-green.svg') }}" class="flex shrink-0 w-5" alt="icon">
                                    <span class="text-sm text-obito-text-secondary">{{ ucfirst($item['course']->difficulty) }} Level</span>
                                </p>
                                
                                <!-- Progress Bar -->
                                <div class="progress-bar-container">
                                    <div class="progress-bar" style="width: {{ $item['progress']['percent'] }}%;"></div>
                                </div>
                                
                                <div class="flex justify-between items-center mt-2">
                                    <p class="text-sm text-obito-text-secondary">{{ $item['progress']['percent'] }}% completed</p>
                                    
                                    <div class="flex gap-3">
                                        @if($item['progress']['percent'] == 100)
                                            <span class="completed-badge">Completed</span>
                                            <a href="{{ route('courses.certificate', $item['course']) }}" class="progress-action-link">
                                                Get Certificate
                                            </a>
                                        @else
                                            <a href="{{ route('dashboard.course.learning.progress', $item['course']->slug) }}" class="progress-action-link">
                                                View Progress
                                            </a>
                                            <a href="{{ route('dashboard.course.details', $item['course']->slug) }}" class="progress-action-link">
                                                Continue
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-10 bg-white rounded-[20px] border border-obito-grey">
                    <img src="{{ asset('assets/images/icons/menu-board-green.svg') }}" class="w-16 h-16 mb-4" alt="No courses">
                    <p class="text-lg font-semibold">You haven't enrolled in any course yet</p>
                    <p class="text-obito-text-secondary mt-1">Browse our catalog and start your learning journey</p>
                    <a href="{{ route('dashboard') }}" class="mt-10 mb-5 px-5 py-3 bg-obito-green text-white rounded-full hover:drop-shadow-effect transition-all duration-300">
                        Browse Courses
                    </a>
                </div>
                @endforelse
            </div>
        </section>
    </main>
@endsection

@push('after-scripts')
    <script>
        // You can add any JavaScript needed for the overview page here
        document.addEventListener('DOMContentLoaded', function() {
            // Animation or interactive features can be added here
        });
    </script>
@endpush