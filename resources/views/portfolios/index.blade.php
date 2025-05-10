@extends('front.layouts.app')
@section('title', 'My Portfolios - Dialogika')
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
        <section id="portfolios" class="flex flex-col w-full max-w-[1280px] px-[75px] gap-4 mx-auto">
            <div class="flex justify-between items-center">
                <h1 class="font-bold text-[22px] leading-[33px]">My Portfolios</h1>
                <a href="{{ route('dashboard.portfolios.create') }}" class="text-white rounded-full py-[10px] px-5 gap-[10px] bg-obito-green hover:drop-shadow-effect transition-all duration-300">
                    <span class="font-semibold">Create New Portfolio</span>
                </a>
            </div>
            
            @if(session('success'))
                <div class="bg-obito-light-green text-obito-green p-4 rounded-[14px] mt-4">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($portfolios->isEmpty())
                <div class="flex flex-col items-center justify-center gap-5 bg-white rounded-[20px] border border-obito-grey p-10 mt-5">
                    <img src="{{ asset('assets/images/icons/ruler&pen.svg') }}" alt="portfolio" class="w-[60px] h-[60px] opacity-50">
                    <div class="text-center">
                        <h2 class="font-bold text-lg">No Portfolios Yet</h2>
                        <p class="text-obito-text-secondary mt-2">Complete a course and showcase your work by creating a portfolio.</p>
                    </div>
                    <a href="{{ route('dashboard') }}" class="text-white rounded-full py-[10px] px-5 mt-3 bg-obito-green hover:drop-shadow-effect transition-all duration-300">
                        <span class="font-semibold">Browse Courses</span>
                    </a>
                </div>
            @else
                <div class="grid grid-cols-2 gap-5 mt-5">
                    @foreach($portfolios as $portfolio)
                    <a href="{{ route('dashboard.portfolios.show', $portfolio->slug) }}" class="portfolio-card">
                        <div class="flex rounded-[20px] border border-obito-grey p-[10px] pr-4 gap-4 bg-white hover:border-obito-green transition-all duration-300">
                            <div class="relative flex shrink-0 w-[240px] h-[150px] rounded-[14px] overflow-hidden bg-obito-grey">
                                <img src="{{ Storage::url($portfolio->image) }}" class="w-full h-full object-cover" alt="portfolio image">
                            </div>
                            <div class="flex flex-col gap-3">
                                <h3 class="font-bold text-lg line-clamp-2">{{ $portfolio->name }}</h3>
                                <p class="flex items-center gap-[6px]">
                                    <img src="{{ asset('assets/images/icons/crown-green.svg') }}" class="flex shrink-0 w-5" alt="icon">
                                    <span class="text-sm text-obito-text-secondary">{{ $portfolio->course->name }}</span>
                                </p>
                                <p class="text-sm text-obito-text-secondary line-clamp-2">{{ $portfolio->description }}</p>
                                <p class="flex items-center gap-[6px]">
                                    <img src="{{ asset('assets/images/icons/calendar-green.svg') }}" class="flex shrink-0 w-5" alt="icon">
                                    <span class="text-sm text-obito-text-secondary">{{ $portfolio->created_at->format('d M Y') }}</span>
                                </p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            @endif
        </section>
    </main>
@endsection