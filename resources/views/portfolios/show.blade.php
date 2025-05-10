@extends('front.layouts.app')
@section('title', $portfolio->name . ' - Portfolio - Dialogika')
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
            <li class="group">
                <a href="{{ route('dashboard.certificates') }}"
                    class="flex items-center gap-2 rounded-full border border-obito-grey py-2 px-[14px] hover:border-obito-green bg-white transition-all duration-300 group-[.active]:bg-obito-light-green group-[.active]:border-obito-light-green">
                    <img src="{{ asset('assets/images/icons/cup.svg') }}" class="flex shrink-0 w-5" alt="icon">
                    <span>Certificates</span>
                </a>
            </li>
            <li class="group active">
                <a href="{{ route('dashboard.portfolios') }}"
                    class="flex items-center gap-2 rounded-full border border-obito-grey py-2 px-[14px] hover:border-obito-green bg-white transition-all duration-300 group-[.active]:bg-obito-light-green group-[.active]:border-obito-light-green">
                    <img src="{{ asset('assets/images/icons/ruler&pen.svg') }}" class="flex shrink-0 w-5" alt="icon">
                    <span>Portfolios</span>
                </a>
            </li>
        </ul>
    </nav>
    <main class="flex flex-col gap-10 pb-10 mt-[30px]">
        <section id="portfolio-detail" class="flex flex-col w-full max-w-[1280px] px-[75px] gap-4 mx-auto">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.portfolios') }}" class="flex items-center justify-center w-10 h-10 rounded-full border border-obito-grey hover:border-obito-green transition-all duration-300">
                    <img src="{{ asset('assets/images/icons/back.svg') }}" alt="back" class="w-5 h-5">
                </a>
                <h1 class="font-bold text-[22px] leading-[33px]">Portfolio Details</h1>
            </div>
            
            <div class="bg-white rounded-[20px] border border-obito-grey p-[30px] mt-5">
                <div class="flex flex-col gap-8">
                    <div class="flex justify-center">
                        <div class="rounded-[14px] overflow-hidden max-w-[800px]">
                            <img src="{{ Storage::url($portfolio->image) }}" alt="{{ $portfolio->name }}" class="w-full h-auto">
                        </div>
                    </div>
                    
                    <div>
                        <h2 class="font-bold text-[28px] leading-[42px] mb-2">{{ $portfolio->name }}</h2>
                        <div class="flex items-center gap-[6px] mb-4">
                            <img src="{{ asset('assets/images/icons/crown-green.svg') }}" class="flex shrink-0 w-5" alt="icon">
                            <span class="text-obito-text-secondary">{{ $portfolio->course->name }}</span>
                        </div>
                        <div class="flex items-center gap-[6px] mb-5">
                            <img src="{{ asset('assets/images/icons/calendar-green.svg') }}" class="flex shrink-0 w-5" alt="icon">
                            <span class="text-obito-text-secondary">Created on {{ $portfolio->created_at->format('d F Y') }}</span>
                        </div>
                        
                        <div class="bg-[#F8FAF9] rounded-[14px] p-6 mb-5">
                            <h3 class="font-semibold text-lg mb-3">Project Description</h3>
                            <p class="text-obito-text-secondary whitespace-pre-line">{{ $portfolio->description }}</p>
                        </div>
                        
                        @if($portfolio->url)
                        <div class="flex justify-center">
                            <a href="{{ $portfolio->url }}" target="_blank" class="flex items-center gap-2 text-white rounded-full py-[10px] px-5 bg-obito-green hover:drop-shadow-effect transition-all duration-300">
                                <img src="{{ asset('assets/images/icons/device-message.svg') }}" class="w-5 h-5" alt="link">
                                <span class="font-semibold">View Live Project</span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection