@extends('front.layouts.app')
@section('title', 'Edit Profile - Dialogika Public Speaking Online Course')
@section('content')
    <x-navigation-auth />
    <nav id="bottom-nav" class="flex w-full bg-white border-b border-obito-grey py-[14px]">
        <ul class="flex w-full max-w-[1280px] px-[75px] mx-auto gap-3">
            <li class="group">
                <a href="#"
                    class="flex items-center gap-2 rounded-full border border-obito-grey py-2 px-[14px] hover:border-obito-green bg-white transition-all duration-300 group-[.active]:bg-obito-light-green group-[.active]:border-obito-light-green">
                    <img src="{{ asset('assets/images/icons/home-trend-up.svg') }}" class="flex shrink-0 w-5" alt="icon">
                    <span>Overview</span>
                </a>
            </li>
            <li class="group active">
                <a href="#"
                    class="flex items-center gap-2 rounded-full border border-obito-grey py-2 px-[14px] hover:border-obito-green bg-white transition-all duration-300 group-[.active]:bg-obito-light-green group-[.active]:border-obito-light-green">
                    <img src="{{ asset('assets/images/icons/note-favorite.svg') }}" class="flex shrink-0 w-5" alt="icon">
                    <span>Courses</span>
                </a>
            </li>
            <li class="group">
                <a href="#"
                    class="flex items-center gap-2 rounded-full border border-obito-grey py-2 px-[14px] hover:border-obito-green bg-white transition-all duration-300 group-[.active]:bg-obito-light-green group-[.active]:border-obito-light-green">
                    <img src="{{ asset('assets/images/icons/message-programming.svg') }}" class="flex shrink-0 w-5" alt="icon">
                    <span>Quizzess</span>
                </a>
            </li>
            <li class="group">
                <a href="#"
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
    <main class="relative flex flex-1 h-full">
        <section class="flex flex-1 items-center py-5 px-5 pl-[calc(((100%-1280px)/2)+75px)]">
            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>
            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                class="flex flex-col h-fit w-[510px] shrink-0 rounded-[20px] border border-obito-grey p-5 gap-4 bg-white">
                @csrf
                @method('patch')
                <h1 class="font-bold text-[22px] leading-[33px]">Profile Settings</h1>
                <label class="relative flex items-center gap-3">
                    <button id="upload-photo" type="button"
                        class="relative w-[90px] h-[90px] flex rounded-full overflow-hidden border border-obito-grey focus:ring-obito-green transition-all duration-300">
                        <span
                            class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 font-semibold text-sm">
                            Add <br>Photo
                        </span>
                        <img id="photo-preview" src="{{ Storage::url($user->photo) }}" class="w-full h-full object-cover {{ $user->photo ? '' : 'hidden' }}" alt="photo">
                    </button>
                    <button id="delete-photo" type="button"
                        class="rounded-full w-fit py-[6px] px-[10px] bg-obito-light-red font-bold text-xs text-obito-red {{ $user->photo ? '' : 'hidden' }}">DELETE
                        PHOTO</button>
                    <input id="hidden-input" name="photo" type="file" accept="image/*"
                        class="absolute -z-10 opacity-0">
                </label>
                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                <div class="flex flex-col gap-2">
                    <p>Complete Name</p>
                    <label class="relative group">
                        <input id="name" name="name" type="text"
                            class="appearance-none outline-none w-full rounded-full border border-obito-grey py-[14px] px-5 pl-12 font-semibold placeholder:font-normal placeholder:text-obito-text-secondary group-focus-within:border-obito-green transition-all duration-300"
                            placeholder="Type your complete name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                        <img src="{{ asset('assets/images/icons/profile.svg') }}""
                            class="absolute size-5 flex shrink-0 transform -translate-y-1/2 top-1/2 left-5" alt="icon">
                    </label>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="flex flex-col gap-2">
                    <p>Occupation</p>
                    <label class="relative group">
                        <input id="occupation" name="occupation" type="text"
                            class="appearance-none outline-none w-full rounded-full border border-obito-grey py-[14px] px-5 pl-12 font-semibold placeholder:font-normal placeholder:text-obito-text-secondary group-focus-within:border-obito-green transition-all duration-300"
                            placeholder="Type your occupation" value="{{ old('occupation', $user->occupation) }}" required>
                        <img src="{{ asset('assets/images/icons/briefcase.svg') }}""
                            class="absolute size-5 flex shrink-0 transform -translate-y-1/2 top-1/2 left-5" alt="icon">
                    </label>
                    <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
                </div>
                <div class="flex flex-col gap-2">
                    <p>Email Address</p>
                    <label class="relative group">
                        <input id="email" name="email" type="email"
                            class="appearance-none outline-none w-full rounded-full border border-obito-grey py-[14px] px-5 pl-12 font-semibold placeholder:font-normal placeholder:text-obito-text-secondary group-focus-within:border-obito-green transition-all duration-300"
                            placeholder="Type your valid email address" value="{{ old('email', $user->email) }}" required autocomplete="username">
                        <img src="{{ asset('assets/images/icons/sms.svg') }}""
                            class="absolute size-5 flex shrink-0 transform -translate-y-1/2 top-1/2 left-5" alt="icon">
                    </label>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800">
                                {{ __('Your email address is unverified.') }}

                                <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
                <button type="submit"
                    class="flex items-center justify-center gap-[10px] rounded-full py-[14px] px-5 bg-obito-green hover:drop-shadow-effect transition-all duration-300">
                    <span class="font-semibold text-white">Save Changes</span>
                </button>
            </form>
        </section>
    </main>
    <script src="{{ asset('js/photo-upload.js') }}"></script>
@endsection
