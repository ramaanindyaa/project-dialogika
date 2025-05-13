@extends('front.layouts.app')
@section('title', 'Login - Dialogika Public Speaking Online Course')

@section('content')
    <x-nav-guest/>
    <main class="relative flex flex-1 h-full">
        
        <section class="flex flex-1 items-center py-5 px-5 pl-[calc(((100%-1280px)/2)+75px)]">
            <form method="POST" action="{{ route('login') }}" class="flex flex-col h-fit w-[510px] shrink-0 rounded-[20px] border border-obito-grey p-5 gap-5 bg-white">
                @csrf
                <h1 class="font-bold text-[22px] leading-[33px] mb-5">Welcome Back, <br>Let’s Upgrade Skills</h1>
                <div class="flex flex-col gap-2">
                    <p>Email Address</p>
                    <label class="relative group">
                        <input name="email" type="email" value="{{ session('success') ? old('email') : '' }}"
                            class="appearance-none outline-none w-full rounded-full border {{ session('success') ? 'border-obito-green ring-1 ring-obito-green' : 'border-obito-grey' }} py-[14px] px-5 pl-12 font-semibold placeholder:font-normal placeholder:text-obito-text-secondary group-focus-within:border-obito-green transition-all duration-300"
                            placeholder="Type your email address">
                        <img src="{{ asset('assets/images/icons/sms.svg') }}"
                            class="absolute size-5 flex shrink-0 transform -translate-y-1/2 top-1/2 left-5"
                            alt="icon">
                    </label>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="flex flex-col gap-3">
                    <p>Password</p>
                    <label class="relative group">
                        <input name="password" type="password"
                            class="appearance-none outline-none w-full rounded-full border border-obito-grey py-[14px] px-5 pl-12 font-semibold placeholder:font-normal placeholder:text-obito-text-secondary group-focus-within:border-obito-green transition-all duration-300"
                            placeholder="Type your password">
                        <img src="{{ asset('assets/images/icons/shield-security.svg') }}"
                            class="absolute size-5 flex shrink-0 transform -translate-y-1/2 top-1/2 left-5"
                            alt="icon">
                    </label>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    <a href="#" class="text-sm text-obito-green hover:underline">Forgot My Password</a>
                </div>
                <button type="submit"
                    class="flex items-center justify-center gap-[10px] rounded-full py-[14px] px-5 bg-obito-green hover:drop-shadow-effect transition-all duration-300">
                    <span class="font-semibold text-white">Sign In to My Account</span>
                </button>
            </form>
        </section>
        <div class="relative flex w-1/2 shrink-0">
            <div id="background-banner" class="absolute flex w-full h-full overflow-hidden">
                <img src="{{ asset('assets/images/backgrounds/banner-subscription.png') }}" class="w-full h-full object-cover"
                    alt="banner">
            </div>
        </div>
    </main>

    <!-- Move success message outside the section to make it full-width and centered -->
    @if (session('success'))
    <div id="success-message" class="fixed top-1/2 left-1/2 transform -translate-x-1/2 z-50 min-w-[300px] text-center bg-obito-light-green text-obito-green py-3 px-6 rounded-full shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
@endif
    
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const successMessage = document.getElementById('success-message');
                
                // Start with opacity 0 and slide in from top
                successMessage.style.opacity = '0';
                successMessage.style.transform = 'translate(-50%, -20px)';
                
                // Fade in
                setTimeout(() => {
                    successMessage.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    successMessage.style.opacity = '1';
                    successMessage.style.transform = 'translate(-50%, 0)';
                    
                    // Start fading out after 5 seconds
                    setTimeout(() => {
                        successMessage.style.opacity = '0';
                        successMessage.style.transform = 'translate(-50%, -20px)';
                        
                        // Remove from DOM after fade completes
                        setTimeout(() => {
                            successMessage.remove();
                        }, 500);
                    }, 5000);
                }, 100);
            });
        </script>
    @endif
@endsection
