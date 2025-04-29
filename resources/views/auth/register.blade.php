@extends('front.layouts.app')
@section('title', 'Register - Dialogika Public Speaking Online Course')

@section('content')
    <x-nav-guest />
    <main class="relative flex flex-1 h-full">
        <section class="flex flex-1 items-center py-5 px-5 pl-[calc(((100%-1280px)/2)+75px)]">
            <form id="registerForm" method="POST" action="{{ route('register') }}" enctype="multipart/form-data"
                class="flex flex-col h-fit w-[510px] shrink-0 rounded-[20px] border border-obito-grey p-5 gap-4 bg-white shadow-[0px_10px_30px_0px_#B8B8B840]">
                @csrf
                <h1 class="font-bold text-[22px] leading-[33px]">Upgrade Your Skills</h1>
                <label class="relative flex items-center gap-3">
                    <button id="upload-photo" type="button"
                        class="relative w-[90px] h-[90px] flex rounded-full overflow-hidden border border-obito-grey focus:ring-obito-green transition-all duration-300">
                        <span
                            class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 font-semibold text-sm">
                            Add <br>Photo
                        </span>
                        <img id="photo-preview" src="" class="w-full h-full object-cover hidden" alt="photo">
                    </button>
                    <button id="delete-photo" type="button"
                        class="rounded-full w-fit py-[6px] px-[10px] bg-obito-light-red font-bold text-xs text-obito-red hidden">DELETE
                        PHOTO</button>
                    <input id="hidden-input" name="photo" type="file" accept="image/*"
                        class="absolute -z-10 opacity-0">
                </label>
                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                
                <div class="flex flex-col gap-2">
                    <p>Complete Name</p>
                    <label class="relative group">
                        <input name="name" type="text" id="name-input"
                            class="appearance-none outline-none w-full rounded-full border border-obito-grey py-[14px] px-5 pl-12 pr-12 font-semibold placeholder:font-normal placeholder:text-obito-text-secondary group-focus-within:border-obito-green transition-all duration-300"
                            placeholder="Type your complete name">
                        <img src="{{ asset('assets/images/icons/profile.svg') }}"
                            class="absolute size-5 flex shrink-0 transform -translate-y-1/2 top-1/2 left-5" alt="icon">
                        <div class="validation-icon hidden absolute top-1/2 transform -translate-y-1/2" style="right: 5px; left: auto;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-obito-green" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </label>
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="flex flex-col gap-2">
                    <p>Occupation</p>
                    <label class="relative group">
                        <input name="occupation" type="text" id="occupation-input"
                            class="appearance-none outline-none w-full rounded-full border border-obito-grey py-[14px] px-5 pl-12 pr-12 font-semibold placeholder:font-normal placeholder:text-obito-text-secondary group-focus-within:border-obito-green transition-all duration-300"
                            placeholder="Type your occupation">
                        <img src="{{ asset('assets/images/icons/briefcase.svg') }}"
                            class="absolute size-5 flex shrink-0 transform -translate-y-1/2 top-1/2 left-5" alt="icon">
                        <div class="validation-icon hidden absolute top-1/2 transform -translate-y-1/2" style="right: 5px; left: auto;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-obito-green" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </label>
                    <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
                </div>

                <div class="flex flex-col gap-2">
                    <p>Email Address</p>
                    <label class="relative group">
                        <input name="email" type="email" id="email-input"
                            class="appearance-none outline-none w-full rounded-full border border-obito-grey py-[14px] px-5 pl-12 pr-12 font-semibold placeholder:font-normal placeholder:text-obito-text-secondary group-focus-within:border-obito-green transition-all duration-300"
                            placeholder="Type your valid email address">
                        <img src="{{ asset('assets/images/icons/sms.svg') }}"
                            class="absolute size-5 flex shrink-0 transform -translate-y-1/2 top-1/2 left-5" alt="icon">
                        <div class="validation-icon hidden absolute top-1/2 transform -translate-y-1/2" style="right: 5px; left: auto;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-obito-green" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </label>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex flex-col gap-2">
                    <p>Password</p>
                    <label class="relative group">
                        <input name="password" type="password" id="password-input"
                            class="appearance-none outline-none w-full rounded-full border border-obito-grey py-[14px] px-5 pl-12 pr-12 font-semibold placeholder:font-normal placeholder:text-obito-text-secondary group-focus-within:border-obito-green transition-all duration-300"
                            placeholder="Type your password">
                        <img src="{{ asset('assets/images/icons/shield-security.svg') }}"
                            class="absolute size-5 flex shrink-0 transform -translate-y-1/2 top-1/2 left-5" alt="icon">
                        <div class="eye-icon absolute top-1/2 transform -translate-y-1/2 cursor-pointer" style="right: 5px; left: auto;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-obito-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                    </label>

                    <!-- Password strength indicator -->
                    <div class="password-strength mt-2 hidden">
                        <div class="flex justify-between mb-1">
                            <span class="text-xs text-obito-text-secondary password-strength-text">Password strength</span>
                            <span class="text-xs font-semibold password-strength-label">Weak</span>
                        </div>
                        <div class="flex gap-1 h-1">
                            <div class="strength-segment bg-obito-grey w-full rounded-full"></div>
                            <div class="strength-segment bg-obito-grey w-full rounded-full"></div>
                            <div class="strength-segment bg-obito-grey w-full rounded-full"></div>
                            <div class="strength-segment bg-obito-grey w-full rounded-full"></div>
                        </div>
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex flex-col gap-2">
                    <p>Confirm Password</p>
                    <label class="relative group">
                        <input name="password_confirmation" type="password" id="confirm-password-input"
                            class="appearance-none outline-none w-full rounded-full border border-obito-grey py-[14px] px-5 pl-12 pr-12 font-semibold placeholder:font-normal placeholder:text-obito-text-secondary group-focus-within:border-obito-green transition-all duration-300"
                            placeholder="Type your password">
                        <img src="{{ asset('assets/images/icons/shield-security.svg') }}"
                            class="absolute size-5 flex shrink-0 transform -translate-y-1/2 top-1/2 left-5" alt="icon">
                        <div class="confirm-eye-icon absolute top-1/2 transform -translate-y-1/2 cursor-pointer" style="right: 5px; left: auto;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-obito-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                        <div class="validation-icon hidden absolute top-1/2 transform -translate-y-1/2" style="right: 30px; left: auto;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-obito-green" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </label>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <button type="submit" id="submit-button" disabled
                    class="flex items-center justify-center gap-[10px] rounded-full py-[14px] px-5 bg-obito-green opacity-70 hover:drop-shadow-effect transition-all duration-300 mt-3">
                    <span class="font-semibold text-white">Create My Account</span>
                </button>
            </form>
        </section>
        <div class="relative flex w-1/2 shrink-0">
            <div id="background-banner" class="absolute flex w-full h-full overflow-hidden">
                <img src="{{ asset('assets/images/backgrounds/banner-subscription.png') }}"
                    class="w-full h-full object-cover" alt="banner">
            </div>
        </div>
    </main>

    <script src="{{ asset('js/photo-upload.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form elements
            const nameInput = document.getElementById('name-input');
            const occupationInput = document.getElementById('occupation-input');
            const emailInput = document.getElementById('email-input');
            const passwordInput = document.getElementById('password-input');
            const confirmPasswordInput = document.getElementById('confirm-password-input');
            const submitButton = document.getElementById('submit-button');
            const eyeIcon = document.querySelector('.eye-icon');
            const confirmEyeIcon = document.querySelector('.confirm-eye-icon');
            const passwordStrength = document.querySelector('.password-strength');
            const strengthSegments = document.querySelectorAll('.strength-segment');
            const strengthLabel = document.querySelector('.password-strength-label');
            
            // Input validation functionality
            const inputs = [nameInput, occupationInput, emailInput, passwordInput, confirmPasswordInput];
            
            // Function to validate inputs and show checkmarks
            function validateInput(input) {
                const validationIcon = input.closest('label').querySelector('.validation-icon');
                
                if (input.value.trim() !== '') {
                    if (input.id === 'email-input') {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (emailRegex.test(input.value)) {
                            validationIcon.classList.remove('hidden');
                        } else {
                            validationIcon.classList.add('hidden');
                        }
                    } else if (input.id === 'confirm-password-input') {
                        if (input.value === passwordInput.value && input.value !== '') {
                            validationIcon.classList.remove('hidden');
                        } else {
                            validationIcon.classList.add('hidden');
                        }
                    } else if (input.id === 'password-input') {
                        // Password doesn't need validation icon as it has strength indicator
                        return;
                    } else {
                        validationIcon.classList.remove('hidden');
                    }
                } else {
                    validationIcon.classList.add('hidden');
                }
                
                updateSubmitButton();
            }
            
            // Function to check password strength
            function checkPasswordStrength(password) {
                if (password.length === 0) {
                    passwordStrength.classList.add('hidden');
                    return;
                }
                
                passwordStrength.classList.remove('hidden');
                
                // Reset all segments
                strengthSegments.forEach(segment => {
                    segment.className = 'strength-segment bg-obito-grey w-full rounded-full';
                });
                
                let score = 0;
                
                // Length check
                if (password.length >= 8) score++;
                
                // Contains numbers
                if (/\d/.test(password)) score++;
                
                // Contains uppercase and lowercase
                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score++;
                
                // Contains special characters
                if (/[^a-zA-Z0-9]/.test(password)) score++;
                
                // Update strength indicator
                for (let i = 0; i < score; i++) {
                    if (score === 1) {
                        strengthSegments[i].className = 'strength-segment bg-obito-red w-full rounded-full';
                        strengthLabel.textContent = 'Weak';
                        strengthLabel.className = 'text-xs font-semibold text-obito-red';
                    } else if (score === 2) {
                        strengthSegments[i].className = 'strength-segment bg-[#FF9500] w-full rounded-full';
                        strengthLabel.textContent = 'Fair';
                        strengthLabel.className = 'text-xs font-semibold text-[#FF9500]';
                    } else if (score === 3) {
                        strengthSegments[i].className = 'strength-segment bg-[#FFD60A] w-full rounded-full';
                        strengthLabel.textContent = 'Good';
                        strengthLabel.className = 'text-xs font-semibold text-[#FFD60A]';
                    } else if (score === 4) {
                        strengthSegments[i].className = 'strength-segment bg-obito-green w-full rounded-full';
                        strengthLabel.textContent = 'Strong';
                        strengthLabel.className = 'text-xs font-semibold text-obito-green';
                    }
                }
                
                return score;
            }
            
            // Function to update submit button state
            function updateSubmitButton() {
                const nameValid = nameInput.value.trim() !== '';
                const occupationValid = occupationInput.value.trim() !== '';
                
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const emailValid = emailRegex.test(emailInput.value);
                
                const passwordValid = passwordInput.value.length >= 8;
                const confirmValid = confirmPasswordInput.value === passwordInput.value && confirmPasswordInput.value !== '';
                
                if (nameValid && occupationValid && emailValid && passwordValid && confirmValid) {
                    submitButton.disabled = false;
                    submitButton.classList.remove('opacity-70');
                } else {
                    submitButton.disabled = true;
                    submitButton.classList.add('opacity-70');
                }
            }
            
            // Event listeners for input fields
            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    validateInput(input);
                    
                    if (input.id === 'password-input') {
                        checkPasswordStrength(input.value);
                        // Re-validate confirm password when password changes
                        validateInput(confirmPasswordInput);
                    }
                });
            });
            
            // Password visibility toggle
            eyeIcon.addEventListener('click', () => {
                togglePasswordVisibility(passwordInput, eyeIcon);
            });
            
            confirmEyeIcon.addEventListener('click', () => {
                togglePasswordVisibility(confirmPasswordInput, confirmEyeIcon);
            });
            
            function togglePasswordVisibility(inputField, icon) {
                if (inputField.type === 'password') {
                    inputField.type = 'text';
                    icon.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-obito-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        </svg>
                    `;
                } else {
                    inputField.type = 'password';
                    icon.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-obito-text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    `;
                }
            }

            // Smooth animation for form appearance
            const form = document.getElementById('registerForm');
            form.style.opacity = '0';
            form.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                form.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                form.style.opacity = '1';
                form.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
@endsection
