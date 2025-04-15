@extends('front.layouts.app')
@section('title', 'Course Learning - Dialogika Public Speaking Online Course')
@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="flex flex-col border border-obito-grey bg-white">
        <!-- Sidebar Header -->
        <div class="w-[260px] pb-[20px] px-5 pt-5 flex flex-col gap-5">
            <ul class="flex flex-col gap-3">
                <li>
                    <a href="{{ route('dashboard') }}" class="navigation-link">
                        <div class="flex items-center gap-3 py-[10px] px-4 rounded-full border border-obito-grey hover:border-obito-green transition-all duration-300">
                            <img src="{{ asset('assets/images/icons/back.svg') }}" alt="icon" class="size-5 shrink-0" />
                            <span class="text-sm font-medium">Back to Dashboard</span>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard.course.learning.progress', $course->slug) }}" class="navigation-link">
                        <div class="flex items-center gap-3 py-[10px] px-4 rounded-full border border-obito-grey hover:border-obito-green transition-all duration-300">
                            <img src="{{ asset('assets/images/icons/home-trend-up.svg') }}" alt="icon" class="size-5 shrink-0" />
                            <span class="text-sm font-medium">View Learning Progress</span>
                        </div>
                    </a>
                </li>
            </ul>
            
            <!-- Course Info -->
            <div class="course-info flex flex-col gap-3 mt-2">
                <div class="flex justify-center items-center overflow-hidden w-full h-[120px] rounded-[14px] border border-obito-grey">
                    <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->name }}" class="w-full h-full object-cover" />
                </div>
                <h1 class="font-bold text-lg leading-tight">{{ $course->name }}</h1>
            </div>
            <hr class="border-obito-grey" />
        </div>
        
        <!-- Lesson Navigator -->
        <div id="lessons-container" class="h-full overflow-y-auto [&::-webkit-scrollbar]:hidden w-[260px]">
            <nav class="px-5 pb-[33px] flex flex-col gap-4">
                <!-- Section Contents -->
                @foreach($course->courseSections as $section)
                <div class="lesson-section flex flex-col gap-3">
                    <button type="button" data-expand="{{ $section->id }}" class="flex items-center justify-between accordion-button w-full text-left">
                        <h2 class="font-semibold text-sm">{{ $section->name }}</h2>
                        <img src="{{ asset('assets/images/icons/arrow-circle-down.svg') }}" alt="toggle" class="size-5 shrink-0 transition-all duration-300" />
                    </button>
                    
                    <div id="section-{{ $section->id }}" class="accordion-content {{ $currentSection && $currentSection->id == $section->id ? 'open' : '' }} pl-2">
                        <ul class="flex flex-col gap-3">
                            <!-- Pre-Quiz -->
                            @if ($section->quizzes->where('type', 'pre')->first())
                                @php
                                    $preQuiz = $section->quizzes->where('type', 'pre')->first();
                                    $isPreQuizCompleted = auth()->user()->userQuizzes->where('quiz_id', $preQuiz->id)->first()?->is_completed;
                                @endphp
                                <li>
                                    <a href="{{ route('quizzes.show', $preQuiz) }}">
                                        <div class="quiz-link flex items-center gap-2 px-4 py-[10px] rounded-full bg-obito-light-green text-obito-green hover:bg-obito-green hover:text-white transition-all duration-300">
                                            <img src="{{ asset('assets/images/icons/message-programming.svg') }}" alt="quiz" class="size-4 shrink-0" />
                                            <span class="text-sm font-medium">Start Pre-Quiz</span>
                                            @if ($isPreQuizCompleted)
                                                <span class="ml-auto text-xs">✓</span>
                                            @endif
                                        </div>
                                    </a>
                                </li>
                            @endif
                            
                            <!-- Section Contents -->
                            @foreach($section->sectionContents as $content)
                                <li class="group {{ $currentSection && $section->id == $currentSection->id && $currentContent->id == $content->id ? 'active' : '' }}">
                                    <a href="{{ route('dashboard.course.learning', [
                                        'course' => $course->slug,
                                        'courseSection' => $section->id,
                                        'sectionContent' => $content->id,
                                    ]) }}">
                                        <div class="lesson-item flex items-center gap-2 px-4 py-[10px] rounded-full border {{ in_array($content->id, $completedContentIds ?? []) ? 'border-obito-green' : 'border-obito-grey' }} 
                                            group-[&.active]:bg-obito-black group-[&.active]:border-transparent group-[&.active]:text-white 
                                            hover:bg-[rgba(47,106,98,0.05)] transition-all duration-300">
                                            
                                            @if($content->type === 'video')
                                                <img src="{{ asset('assets/images/icons/video.svg') }}" alt="video" class="size-4 shrink-0 group-[&.active]:brightness-200" />
                                            @else
                                                <img src="{{ asset('assets/images/icons/document-text.svg') }}" alt="text" class="size-4 shrink-0 group-[&.active]:brightness-200" />
                                            @endif
                                            
                                            <h3 class="text-sm font-medium leading-tight line-clamp-1 flex-1">
                                                {{ $content->name }}
                                            </h3>
                                            
                                            @if(in_array($content->id, $completedContentIds ?? []))
                                                <span class="text-xs text-obito-green group-[&.active]:text-white">✓</span>
                                            @endif
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                            
                            <!-- Post-Quiz -->
                            @if ($section->quizzes->where('type', 'post')->first())
                                @php
                                    $postQuiz = $section->quizzes->where('type', 'post')->first();
                                    $isPostQuizCompleted = auth()->user()->userQuizzes->where('quiz_id', $postQuiz->id)->first()?->is_completed;
                                @endphp
                                <li>
                                    <a href="{{ route('quizzes.show', $postQuiz) }}">
                                        <div class="quiz-link flex items-center gap-2 px-4 py-[10px] rounded-full bg-obito-light-green text-obito-green hover:bg-obito-green hover:text-white transition-all duration-300">
                                            <img src="{{ asset('assets/images/icons/message-programming.svg') }}" alt="quiz" class="size-4 shrink-0" />
                                            <span class="text-sm font-medium">Start Post-Quiz</span>
                                            @if ($isPostQuizCompleted)
                                                <span class="ml-auto text-xs">✓</span>
                                            @endif
                                        </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <hr class="border-obito-grey" />
                @endforeach
            </nav>
        </div>
    </aside>
    
    <!-- Content Area -->
    <div class="flex-grow overflow-y-auto">
        <main class="pt-[30px] pb-[118px] pl-[50px] pr-[50px]">
            <article>
                <div class="content-ebook">
                    <h1 class="text-[28px] font-bold mb-6 leading-[42px]">{{ $currentContent->name }}</h1>
                    @if ($currentContent->type === 'text')
                        {!! $currentContent->content !!}
                    @elseif ($currentContent->type === 'video')
                        <div class="responsive-video rounded-[14px] overflow-hidden shadow-[0px_4px_20px_0px_rgba(0,0,0,0.1)]">
                            <iframe 
                                src="{{ $currentContent->video_url }}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                            </iframe>
                        </div>
                    @endif
                </div>
            </article>
        </main>
    </div>
    
    <!-- Bottom Navigation Bar -->
    <nav class="fixed bottom-0 left-auto right-0 z-30 mx-auto w-[calc(100%-260px)] pt-5 pb-[30px] bg-[#F8FAF9]">
        <div class="px-[30px]">
            <div class="flex items-center justify-between bg-white rounded-[20px] border border-obito-grey p-4 shadow-[0px_4px_20px_0px_rgba(0,0,0,0.03)]">
                <p class="text-sm text-obito-text-secondary">Pelajari materi dengan baik, jika bingung maka tanya mentor kelas</p>
                <div class="flex items-center gap-3">
                    <a href="#" class="px-4 py-2 rounded-full border border-obito-grey bg-white text-sm font-semibold hover:border-obito-green transition-all duration-300">
                        Ask Mentor
                    </a>

                    @if (!$isFinished)
                    <a href="{{ route('dashboard.course.learning', [
                                'course' => $course->slug,
                                'courseSection' => $nextContent->course_section_id,
                                'sectionContent' => $nextContent->id,
                            ]) }}" id="next-lesson-btn" class="px-4 py-2 rounded-full bg-obito-green text-white text-sm font-semibold hover:drop-shadow-effect transition-all duration-300" data-target-section="{{ $nextContent->course_section_id }}">
                        Next Lesson
                    </a>
                    @else
                    <a href="{{ route('dashboard.course.learning.finished', $course->slug) }}" class="px-4 py-2 rounded-full bg-obito-green text-white text-sm font-semibold hover:drop-shadow-effect transition-all duration-300">
                        Finish Learning
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</div>
@endsection

@push('after-styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">
    <link rel="stylesheet" href="{{ asset('css/content.css') }}">
    <style>
        /* Additional custom styles */
        .accordion-button img {
            transform: rotate(0);
            transition: transform 0.3s ease;
        }
        
        .accordion-content.open + .accordion-button img,
        .accordion-content.open ~ button img {
            transform: rotate(-180deg);
        }
        
        .lesson-item {
            position: relative;
        }
        
        .quiz-link {
            position: relative;
        }
        
        /* Improved scrollbar */
        #lessons-container {
            scrollbar-width: thin;
            scrollbar-color: rgba(47, 106, 98, 0.3) transparent;
        }
        
        /* For webkit browsers */
        #lessons-container::-webkit-scrollbar {
            width: 4px;
        }
        
        #lessons-container::-webkit-scrollbar-thumb {
            background-color: rgba(47, 106, 98, 0.3);
            border-radius: 4px;
        }
        
        #lessons-container::-webkit-scrollbar-track {
            background-color: transparent;
        }
    </style>
@endpush

@push('after-scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{ asset('js/accordion.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Code highlighting initialization
        document.querySelectorAll('pre').forEach(pre => {
            pre.classList.add('theme-tokyo-night-dark', 'rounded-[14px]', 'my-4');

            if (!pre.querySelector('code')) {
                const code = document.createElement('code');
                code.textContent = pre.textContent.trim();
                pre.innerHTML = '';
                pre.appendChild(code);
            }
        });
        hljs.highlightAll();
        
        // Accordion functionality
        const accordionButtons = document.querySelectorAll('.accordion-button');
        const nextLessonButton = document.getElementById('next-lesson-btn');

        accordionButtons.forEach(button => {
            button.addEventListener('click', () => {
                const content = document.querySelector(`#section-${button.dataset.expand}`);
                const arrow = button.querySelector('img');
                
                // Close other accordions
                document.querySelectorAll('.accordion-content.open').forEach(openContent => {
                    if (openContent !== content) {
                        openContent.style.maxHeight = null;
                        openContent.classList.remove('open');
                        
                        // Reset rotation of other accordion buttons
                        const otherButton = document.querySelector(`[data-expand="${openContent.id.split('-')[1]}"]`);
                        if (otherButton) {
                            const otherArrow = otherButton.querySelector('img');
                            if (otherArrow) otherArrow.style.transform = 'rotate(0deg)';
                        }
                    }
                });

                // Toggle current accordion
                if (content.classList.contains('open')) {
                    content.style.maxHeight = null;
                    content.classList.remove('open');
                    arrow.style.transform = 'rotate(0deg)';
                } else {
                    content.style.maxHeight = content.scrollHeight + 'px';
                    content.classList.add('open');
                    arrow.style.transform = 'rotate(-180deg)';
                }
            });
        });

        // Next lesson navigation with smooth section transitions
        if (nextLessonButton) {
            nextLessonButton.addEventListener('click', (event) => {
                event.preventDefault();
                const targetSectionId = nextLessonButton.dataset.targetSection;
                const currentSectionId = document.querySelector('.accordion-content.open')?.id?.split('-')[1];
                
                if (currentSectionId !== targetSectionId) {
                    const content = document.querySelector(`#section-${targetSectionId}`);
                    
                    document.querySelectorAll('.accordion-content.open').forEach(openContent => {
                        if (openContent !== content) {
                            openContent.style.maxHeight = null;
                            openContent.classList.remove('open');
                        }
                    });

                    if (content) {
                        content.style.maxHeight = content.scrollHeight + 'px';
                        content.classList.add('open');
                        
                        const button = document.querySelector(`[data-expand="${targetSectionId}"]`);
                        if (button) {
                            const arrow = button.querySelector('img');
                            if (arrow) arrow.style.transform = 'rotate(-180deg)';
                        }
                    }

                    setTimeout(() => {
                        window.location.href = nextLessonButton.href;
                    }, 300);
                } else {
                    window.location.href = nextLessonButton.href;
                }
            });
        }
    });
</script>
@endpush
