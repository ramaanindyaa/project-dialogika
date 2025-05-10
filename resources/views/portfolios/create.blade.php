@extends('front.layouts.app')
@section('title', 'Buat Portfolio - Dialogika')
@section('content')
    <x-navigation-auth />
    <main class="flex flex-col gap-10 pb-10 mt-[50px]">
        <section id="create-portfolio" class="flex flex-col w-full max-w-[800px] px-[75px] gap-[30px] mx-auto">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard.portfolios') }}" class="flex items-center justify-center w-10 h-10 rounded-full border border-obito-grey hover:border-obito-green transition-all duration-300">
                        <img src="{{ asset('assets/images/icons/back.svg') }}" alt="kembali" class="w-5 h-5">
                    </a>
                    <h1 class="font-bold text-[28px] leading-[42px]">Buat Portfolio</h1>
                </div>
                <div class="flex items-center gap-2 bg-obito-light-green rounded-full py-2 px-[14px]">
                    <img src="{{ asset('assets/images/icons/crown-green.svg') }}" class="flex shrink-0 w-5" alt="icon">
                    <span class="text-obito-green text-sm font-semibold">Tampilkan Karya Terbaikmu</span>
                </div>
            </div>
            
            <div class="bg-white rounded-[20px] border border-obito-grey p-[30px] shadow-[0px_10px_30px_0px_#B8B8B840]">
                @if($completedCourses->isEmpty())
                    <div class="flex flex-col items-center justify-center gap-[30px] text-center py-[70px]">
                        <div class="bg-obito-light-green rounded-full p-[30px]">
                            <img src="{{ asset('assets/images/icons/ruler&pen.svg') }}" alt="portfolio" class="w-[60px] h-[60px] text-obito-green">
                        </div>
                        <div class="max-w-[500px] px-5">
                            <h2 class="font-bold text-xl mb-5">Selesaikan Kelas Terlebih Dahulu</h2>
                            <p class="text-obito-text-secondary leading-[28px]">Kamu perlu menyelesaikan kelas <span class="font-semibold">100%</span> sebelum dapat membuat portfolio. Progres kelas harus mencapai 100% untuk dapat membuat portfolio.</p>
                        </div>
                        <div class="flex gap-4 mt-5">
                            <a href="{{ route('dashboard') }}" class="text-white rounded-full py-[14px] px-5 bg-obito-green hover:drop-shadow-effect transition-all duration-300">
                                <span class="font-semibold">Lihat Kelas</span>
                            </a>
                            <a href="{{ route('dashboard') }}" class="rounded-full py-[14px] px-5 border border-obito-grey hover:border-obito-green transition-all duration-300">
                                <span class="font-semibold">Kembali ke Dashboard</span>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="mb-8 pb-6 border-b border-obito-grey">
                        <h2 class="font-semibold text-xl mb-3">Informasi Portfolio</h2>
                        <p class="text-obito-text-secondary leading-[28px]">Tampilkan karya terbaikmu dan tunjukkan kemampuanmu kepada calon pemberi kerja atau klien.</p>
                    </div>
                    
                    <form action="{{ route('dashboard.portfolios.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-[30px]">
                        @csrf
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-[#F8FAF9] p-[30px] rounded-[14px] border border-obito-grey hover:border-obito-green transition-all duration-300">
                                <label for="name" class="block font-semibold mb-3">Nama Portfolio</label>
                                <div class="relative">
                                    <input type="text" name="name" id="name" class="w-full border border-obito-grey rounded-[14px] py-3 px-4 outline-none focus:ring-obito-green focus:border-obito-green transition-all duration-300" placeholder="Contoh: Website E-commerce, Desain Aplikasi Mobile" required>
                                </div>
                                <p class="text-xs text-obito-text-secondary mt-3">Berikan nama deskriptif untuk proyek Anda (maksimal 100 karakter)</p>
                                @error('name')
                                    <p class="text-obito-red text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="bg-[#F8FAF9] p-[30px] rounded-[14px] border border-obito-grey hover:border-obito-green transition-all duration-300">
                                <label for="course_id" class="block font-semibold mb-3">Pilih Kelas yang Telah Diselesaikan</label>
                                <div class="relative">
                                    <select name="course_id" id="course_id" class="w-full border border-obito-grey rounded-[14px] py-3 px-4 appearance-none outline-none focus:ring-obito-green focus:border-obito-green transition-all duration-300" required>
                                        <option value=""> Pilih Kelas </option>
                                        @foreach($completedCourses as $course)
                                            <option value="{{ $course->id }}" {{ isset($selectedCourseId) && $selectedCourseId == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <div class="absolute right-4 mx-auto top-1/2 -translate-y-1/2 pointer-events-none">
                                        <img src="{{ asset('assets/images/icons/back.svg') }}" class="w-5 h-5 -rotate-180" alt="dropdown">
                                    </div> --}}
                                </div>
                                <p class="text-xs text-obito-text-secondary mt-3">Hanya kelas yang telah 100% selesai yang akan muncul di daftar ini</p>
                                @error('course_id')
                                    <p class="text-obito-red text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="bg-[#F8FAF9] p-[30px] rounded-[14px] border border-obito-grey hover:border-obito-green transition-all duration-300">
                            <label for="description" class="block font-semibold mb-3">Deskripsi Proyek</label>
                            <textarea name="description" id="description" rows="6" class="w-full border border-obito-grey rounded-[14px] py-3 px-4 outline-none focus:ring-obito-green focus:border-obito-green transition-all duration-300" placeholder="Jelaskan tentang proyek Anda, termasuk tantangan yang dihadapi dan bagaimana Anda mengatasinya" required></textarea>
                            <p class="text-xs text-obito-text-secondary mt-3">Berikan deskripsi lengkap tentang proyek Anda (minimal 100 karakter)</p>
                            @error('description')
                                <p class="text-obito-red text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="bg-[#F8FAF9] p-[30px] rounded-[14px] border border-obito-grey hover:border-obito-green transition-all duration-300">
                            <label for="url" class="block font-semibold mb-3">URL Proyek <span class="text-xs font-normal text-obito-text-secondary">(Opsional)</span></label>
                            <div class="relative">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <img src="{{ asset('assets/images/icons/device-message.svg') }}" class="w-5 h-5 opacity-50" alt="link">
                                </div>
                                <input type="url" name="url" id="url" class="w-full border border-obito-grey rounded-[14px] py-3 pl-12 pr-4 outline-none focus:ring-obito-green focus:border-obito-green transition-all duration-300" placeholder="https://contoh.com">
                            </div>
                            <p class="text-xs text-obito-text-secondary mt-3">Tambahkan tautan ke proyek live, repositori GitHub, atau portfolio design Anda</p>
                            @error('url')
                                <p class="text-obito-red text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="bg-[#F8FAF9] p-[30px] rounded-[14px] border border-obito-grey hover:border-obito-green transition-all duration-300">
                            <label class="block font-semibold mb-5">Gambar Portfolio</label>
                            <div id="imageUploadContainer" class="border-2 border-dashed border-obito-grey bg-white rounded-[14px] flex flex-col items-center justify-center p-[30px] hover:border-obito-green transition-all duration-300 cursor-pointer">
                                <input type="file" name="image" id="imageUpload" class="hidden" accept="image/*" required>
                                <div id="uploadPlaceholder">
                                    {{-- <div class="bg-white p-[14px] rounded-full mb-5 border border-obito-grey">
                                        <img src="{{ asset('assets/images/icons/document-text.svg') }}" alt="upload" class="w-[50px] h-[50px] opacity-50">
                                    </div> --}}
                                    <p class="font-semibold text-lg mb-3 text-center">Tarik & Lepas Gambar</p>
                                    <p class="text-center text-sm text-obito-text-secondary">Unggah gambar berkualitas tinggi (dimensi 1048x700px dan ukuran maksimum 2MB)</p>
                                    <div class="flex justify-center mt-5">
                                        <button type="button" class="py-[14px] px-5 bg-white border border-obito-grey rounded-full hover:border-obito-green transition-all duration-300 text-sm font-semibold">
                                            Pilih File
                                        </button>
                                    </div>
                                </div>
                                <div id="imagePreviewContainer" class="hidden w-full">
                                    <div class="relative">
                                        <img id="imagePreview" class="max-w-full max-h-[350px] h-auto mx-auto rounded-[14px]" alt="Preview">
                                        <button type="button" id="removeImage" class="absolute bottom-3 right-3 bg-white rounded-full p-3 shadow-[0px_10px_30px_0px_#B8B8B840] hover:bg-obito-light-red transition-all duration-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ef372b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M3 6h18"></path>
                                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                                <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs text-obito-text-secondary mt-3">Unggah gambar yang paling mewakili proyek Anda</p>
                            @error('image')
                                <p class="text-obito-red text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex justify-end gap-4 pt-[30px] mt-5 border-t border-obito-grey">
                            <a href="{{ route('dashboard.portfolios') }}" class="rounded-full py-[14px] px-5 border border-obito-grey hover:border-obito-green transition-all duration-300">
                                <span class="font-semibold">Batal</span>
                            </a>
                            <button type="submit" class="text-white rounded-full py-[14px] px-5 bg-obito-green hover:drop-shadow-effect transition-all duration-300 flex items-center gap-2">
                                <span class="font-semibold">Buat Portfolio</span>
                                <img src="{{ asset('assets/images/icons/arrow-circle-down.svg') }}" class="w-5 h-5 -rotate-90" alt="submit">
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </section>
    </main>
@endsection

@push('after-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageUploadContainer = document.getElementById('imageUploadContainer');
        const imageUpload = document.getElementById('imageUpload');
        const imagePreview = document.getElementById('imagePreview');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const removeImageButton = document.getElementById('removeImage');
        const selectFileButton = uploadPlaceholder.querySelector('button');

        // Click on container to trigger file input
        selectFileButton.addEventListener('click', function(e) {
            e.stopPropagation();
            imageUpload.click();
        });
        
        imageUploadContainer.addEventListener('click', function() {
            imageUpload.click();
        });

        // Handle drag and drop
        imageUploadContainer.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            imageUploadContainer.classList.add('border-obito-green');
            imageUploadContainer.classList.add('bg-obito-light-green');
        });

        imageUploadContainer.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            imageUploadContainer.classList.remove('border-obito-green');
            imageUploadContainer.classList.remove('bg-obito-light-green');
        });

        imageUploadContainer.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            imageUploadContainer.classList.remove('border-obito-green');
            imageUploadContainer.classList.remove('bg-obito-light-green');
            
            if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                imageUpload.files = e.dataTransfer.files;
                updatePreview(e.dataTransfer.files[0]);
            }
        });

        // Handle file selection
        imageUpload.addEventListener('change', function() {
            if (imageUpload.files && imageUpload.files[0]) {
                updatePreview(imageUpload.files[0]);
            }
        });

        // Remove image
        removeImageButton.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent triggering container click
            imageUpload.value = '';
            uploadPlaceholder.classList.remove('hidden');
            imagePreviewContainer.classList.add('hidden');
        });

        function updatePreview(file) {
            if (!file.type.startsWith('image/')) {
                alert('Silakan pilih file gambar.');
                return;
            }
            
            // Check file size (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file melebihi batas 2MB. Silakan pilih gambar yang lebih kecil.');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                uploadPlaceholder.classList.add('hidden');
                imagePreviewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush