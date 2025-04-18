@extends('front.layouts.app')
@section('title', 'My Certificates - Dialogika Public Speaking Online Course')
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
            <li class="group">
                <a href="{{ route('dashboard.quizzes.history') }}"
                    class="flex items-center gap-2 rounded-full border border-obito-grey py-2 px-[14px] hover:border-obito-green bg-white transition-all duration-300 group-[.active]:bg-obito-light-green group-[.active]:border-obito-light-green">
                    <img src="{{ asset('assets/images/icons/message-programming.svg') }}" class="flex shrink-0 w-5" alt="icon">
                    <span>Quizzes</span>
                </a>
            </li>
            <li class="group active">
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
        <!-- Header Section -->
        <section class="flex flex-col w-full max-w-[1280px] px-[75px] mx-auto">
            <div class="flex items-center justify-between">
                <h1 class="font-bold text-[32px] leading-[42px]">My Certificates</h1>
            </div>
            <p class="text-obito-text-secondary mt-1">View and download certificates for your completed courses.</p>
        </section>
        
        <!-- Certificates Section -->
        <section class="flex flex-col w-full max-w-[1280px] px-[75px] gap-5 mx-auto">
            @if($completedCourses->count() > 0)
                <div class="grid grid-cols-2 gap-5">
                    @foreach($completedCourses as $course)
                        <div class="certificate-card flex flex-col rounded-[20px] border border-obito-grey overflow-hidden bg-white hover:border-obito-green transition-all duration-300">
                            <!-- Certificate Header -->
                            <div class="relative flex w-full h-[150px]">
                                <img src="{{ Storage::url($course->thumbnail) }}" class="w-full h-full object-cover" alt="course thumbnail">
                                <div class="absolute inset-0 bg-black bg-opacity-20 flex items-center justify-center">
                                    <div class="rounded-full p-3">
                                        <img src="{{ asset('assets/images/icons/cup-green-fill.svg') }}" class="w-10 h-10" alt="certificate">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Certificate Content -->
                            <div class="p-5 flex flex-col flex-1">
                                <h4 class="font-bold text-lg line-clamp-2 mb-5">{{ $course->name }}</h4>
                                
                                <div class="flex flex-col gap-2">
                                    <div class="flex items-center gap-[6px]">
                                        <img src="{{ asset('assets/images/icons/crown-green.svg') }}" class="flex shrink-0 w-5" alt="icon">
                                        <span class="text-sm text-obito-text-secondary">{{ $course->category->name }}</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-[6px]">
                                        <img src="{{ asset('assets/images/icons/menu-board-green.svg') }}" class="flex shrink-0 w-5" alt="icon">
                                        <span class="text-sm text-obito-text-secondary">{{ $course->courseSections->count() }} Sections</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-[6px]">
                                        <img src="{{ asset('assets/images/icons/briefcase-green.svg') }}" class="flex shrink-0 w-5" alt="icon">
                                        <span class="text-sm text-obito-text-secondary">{{ ucfirst($course->difficulty) }} Level</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-[6px] mt-1">
                                        <img src="{{ asset('assets/images/icons/calendar-green.svg') }}" class="flex shrink-0 w-5" alt="icon">
                                        <span class="text-sm text-obito-text-secondary">Completed on {{ $course->courseStudents->where('user_id', auth()->id())->first()->updated_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                                
                                <div class="flex gap-3 mt-auto pt-5">
                                    <a href="{{ route('courses.certificate', $course) }}" class="flex-1 text-center py-2 px-5 bg-obito-green text-white rounded-full font-semibold hover:drop-shadow-effect transition-all duration-300">
                                        Download Certificate
                                    </a>
                                    <a href="{{ route('courses.certificate.preview', $course) }}" class="py-2 px-5 border border-obito-grey rounded-full hover:border-obito-green transition-all duration-300">
                                        Preview
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-10 bg-white rounded-[20px] border border-obito-grey">
                    <img src="{{ asset('assets/images/icons/cup.svg') }}" class="w-16 h-16 mb-4" alt="No certificates">
                    <p class="text-lg font-semibold">You haven't completed any courses yet</p>
                    <p class="text-obito-text-secondary mt-1">Complete courses to earn certificates</p>
                    <a href="{{ route('dashboard') }}" class="mt-10 mb-5 px-5 py-3 bg-obito-green text-white rounded-full hover:drop-shadow-effect transition-all duration-300">
                        Browse Courses
                    </a>
                </div>
            @endif
        </section>
    </main>
@endsection