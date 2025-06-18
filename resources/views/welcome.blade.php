<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platform Pembelajaran AWBIT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Pastikan 'npm run dev' berjalan agar @apply berfungsi */
        @tailwind base;
        @tailwind components;
        @tailwind utilities;

        @layer base {
            body {
                font-family: 'Inter', sans-serif;
                scroll-behavior: smooth;
                overflow-x: hidden;
            }
        }
        
        .hero-bg-animated {
            background: linear-gradient(-45deg, #3b82f6, #10b981, #8b5cf6, #ec4899);
            background-size: 400% 400%;
            animation: gradientAnimation 15s ease infinite;
            color: white;
            position: relative;
            overflow: hidden; 
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @layer components {
            .btn-hero {
                @apply bg-white hover:bg-gray-100 text-blue-600 font-semibold py-3 px-7 rounded-lg shadow-lg 
                       transform transition-all duration-300 ease-in-out 
                       hover:-translate-y-1 hover:scale-110 hover:shadow-xl hover:rotate-[-2deg];
            }
            .card {
                @apply bg-white p-6 rounded-xl shadow-lg transition-all duration-300 ease-in-out hover:shadow-2xl hover:scale-105;
            }
            .resource-card {
                @apply bg-white rounded-lg shadow-lg overflow-hidden 
                       transform transition-all duration-300 ease-in-out 
                       hover:shadow-2xl hover:scale-[1.03] hover:-translate-y-2;
            }
            .resource-card-top-border-blue { @apply border-t-4 border-blue-500; }
            .resource-card-top-border-green { @apply border-t-4 border-green-500; }
            .resource-card-top-border-purple { @apply border-t-4 border-purple-500; }
        }
        
        /* Utility classes from your design */
        .resource-tag { @apply inline-block bg-gray-100 text-gray-700 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded-full; }
        .resource-tag-course { @apply bg-yellow-100 text-yellow-800; }
        .resource-tag-video { @apply bg-red-100 text-red-800; }
        .resource-tag-article { @apply bg-blue-100 text-blue-800; }
        .resource-tag-level { @apply text-xs font-semibold; }
        .resource-tag-level-beginner { @apply text-green-600; }
        .resource-tag-level-intermediate { @apply text-yellow-600; }
        .resource-tag-level-advanced { @apply text-red-600; }
        .resource-tag-level-all { @apply text-purple-600; }
        .icon-placeholder { @apply text-3xl mb-3; }
        .hero-bg-animated h1, .hero-bg-animated .hero-subtext { color: white; }

        .hero-image-container { 
            position: relative; 
            /* Ukuran diperbesar */
            width: 600px; 
            height: 600px; 
            margin: 0 auto; 
        }
        .hero-image-circle {
            width: 100%; height: 100%; border-radius: 50%; object-fit: cover; border: 6px solid white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2); animation: floatImage 6s ease-in-out infinite;
        }
        @keyframes floatImage { 0% { transform: translateY(0px); } 50% { transform: translateY(-10px); } 100% { transform: translateY(0px); } }
        .blob { position: absolute; border-radius: 50%; filter: blur(5px); opacity: 0.6; animation: floatBlob 8s ease-in-out infinite alternate; z-index: -1; }
        .blob1 { width: 190px; height: 190px; background-color: rgba(236, 72, 153, 0.7); top: 30px; left: 80px; animation-delay: 0s; }
        .blob2 { width: 160px; height: 160px; background-color: rgba(79, 240, 64, 0.82); bottom: 170px; right: 150px; animation-delay: -2s; }
        .blob3 { width: 100px; height: 100px; background-color: rgba(255, 242, 55, 0.92); top: 65%; left: 20px; animation-delay: -4s; }
        @keyframes floatBlob { from { transform: translateY(0px) translateX(0px) scale(1); } to { transform: translateY(15px) translateX(-10px) scale(1.1); } }

        .wave-bottom-hero { position: absolute; bottom: -1px; left: 0; width: 100%; z-index: 5; line-height: 0; }
        .wave-svg { display: block; width: 100%; height: auto; }

        .animate-on-scroll { opacity: 0; transform: translateY(40px); transition: opacity 0.7s ease-out, transform 0.7s ease-out; }
        .animate-on-scroll.is-visible { opacity: 1; transform: translateY(0); }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- Header Section - Dibuat Fixed dengan efek Glassmorphism -->
    <header id="main-header" class="fixed top-0 left-0 right-0 z-40 bg-white/20 backdrop-blur-lg border-b border-white/30 shadow-md transition-all duration-300 ease-in-out">
        <nav class="container mx-auto px-4 sm:px-6 py-4 flex justify-between items-center">
            <div>
                {{-- <img src="{{ asset('img/logo.jpg') }} " style="width: 5%; height: 5%;"/> --}}
                <a href="{{ url('/') }}" id="brand-logo" class="text-3xl font-bold text-white transition-colors duration-300" style="text-shadow: 0 1px 3px rgba(0,0,0,0.2);">AWBIT</a>
            </div>
            <div>
                {{-- Logika untuk menampilkan tombol yang berbeda berdasarkan status login --}}
                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-white text-blue-600 font-semibold py-2 px-5 rounded-lg shadow-md transform transition-all duration-300 ease-in-out hover:bg-gray-200 hover:shadow-lg hover:scale-105">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class=" relative inline-flex items-center justify-center px-8 py-3 font-bold text-sm text-white bg-gradient-to-r from-blue-400 to-purple-500 rounded-full shadow-lg overflow-hidden group transition-all duration-300 ease-in-out hover:from-blue-600 hover:to-purple-700 hover:shadow-xl hover:shadow-blue-500/50 hover:scale-105 active:scale-95 /">
                        <span class="relative z-10">Login</span>
                        <span class="ml-2 relative z-10 transition-transform duration-300 group-hover:translate-x-1">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </span>
                    <span class="absolute inset-0 bg-white opacity-0 group-hover:opacity-10 transition-opacity duration-300 ease-in-out mix-blend-overlay"></span>
    </a>
                @endauth
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero-bg-animated min-h-screen flex items-center relative">
        {{-- Konten Hero --}}
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8 md:gap-12">
                <div class="w-full md:w-1/2 text-center md:text-left relative z-10">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                        Selamat Datang di AWBIT
                    </h1>
                    <p class="hero-subtext text-lg md:text-xl text-gray-100 mb-10 max-w-xl mx-auto md:mx-0">
                        Platform pembelajaran modern untuk kolaborasi efektif antara dosen dan mahasiswa.
                    </p>
                    <a href="{{ route('register') }}" class="btn-hero">
                        <button class="bg-white hover:bg-gray-100 text-blue-600 font-semibold py-3 px-7 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out hover:-translate-y-1 hover:scale-110 hover:shadow-xl hover:rotate-[-2deg]">
                        Mulai Sekarang</button>
                    </a>
                </div>
                <div class="hidden md:flex md:w-1/2 justify-center md:justify-end relative z-10 mt-10 md:mt-0">
                    <div class="hero-image-container">
                        <div class="blob blob1"></div>
                        <div class="blob blob2"></div>
                        <div class="blob blob3"></div>
                        <img src="{{ asset('img/hero.png') }}" 
                             alt="Ilustrasi Pembelajaran"
                             
                             onerror="this.onerror=null; this.src='https://placehold.co/400x400/e2e8f0/334155?text=AWBIT&font=inter';">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- WAVE AFTER HERO -->
        <div class="wave-bottom-hero">
            <svg class="wave-svg" style="transform: translateY(10px); opacity: 0.5;" viewBox="0 0 1440 150" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg"><path d="M0,80 C200,150 350,50 720,80 C1000,110 1200,10 1440,80 L1440,150 L0,150 Z" fill="rgba(249,250,251,0.7)"></path></svg>
            <svg class="wave-svg" style="position:absolute; bottom:0; left:0;" viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg"><path d="M0,64 C240,128 480,128 720,64 C960,0 1200,0 1440,64 L1440,120 L0,120 Z" fill="rgba(249,250,251,1)"></path></svg>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="py-16 md:py-24 bg-gray-50 relative z-0 animate-on-scroll">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="grid md:grid-cols-2 gap-8 lg:gap-12 items-start">
                <!-- Card for Educators -->
                <div class="card">
                    <div class="icon-placeholder text-blue-500">🧑‍🏫</div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Untuk Para Pendidik</h2>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-start"><svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><span><strong>Manajemen Kelas Efisien:</strong> Unggah materi, buat tugas, dan kelola kelas.</span></li>
                        <li class="flex items-start"><svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><span><strong>Penilaian Transparan:</strong> Berikan feedback dan nilai tugas secara online.</span></li>
                        <li class="flex items-start"><svg class="w-5 h-5 text-blue-500 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><span><strong>Komunikasi Lancar:</strong> Forum diskusi dan pengumuman interaktif.</span></li>
                    </ul>
                </div>
                <!-- Card for Students -->
                <div class="card">
                    <div class="icon-placeholder text-green-500">🎓</div>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Untuk Para Mahasiswa</h2>
                    <ul class="space-y-3 text-gray-600">
                        <li class="flex items-start"><svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><span><strong>Akses Materi Kapan Saja:</strong> Unduh materi kuliah dan sumber belajar.</span></li>
                        <li class="flex items-start"><svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><span><strong>Pengumpulan Tugas Terstruktur:</strong> Submit tugas online dan pantau status.</span></li>
                        <li class="flex items-start"><svg class="w-5 h-5 text-green-500 mr-3 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><span><strong>Belajar Interaktif:</strong> Ikuti diskusi kelas dan dapatkan feedback.</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Features Section -->
    <section class="bg-gray-100 py-16 md:py-24 relative z-0 animate-on-scroll">
        <div class="container mx-auto px-4 sm:px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-4">Jelajahi Fitur Unggulan</h2>
            <p class="text-center text-gray-600 mb-16 max-w-2xl mx-auto">Temukan berbagai sumber daya dan alat bantu yang dirancang untuk memaksimalkan pengalaman belajar mengajar Anda di AWBIT.</p>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature Card 1 -->
                <div class="resource-card resource-card-top-border-blue">
                    <div class="p-6">
                        <div class="flex items-center mb-3"><span class="resource-tag resource-tag-article">ARTIKEL</span><span class="resource-tag-level resource-tag-level-all ml-auto">Semua Level</span></div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Panduan Notifikasi Cerdas</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Pelajari cara memaksimalkan notifikasi agar tidak ketinggalan info penting, tugas, atau tenggat waktu.</p>
                        <div class="flex justify-between items-center text-sm text-gray-500"><span><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.414-1.415L11 9.586V6z" clip-rule="evenodd" /></svg>5 min baca</span><a href="#" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors">Baca Sekarang <span aria-hidden="true">&rarr;</span></a></div>
                    </div>
                </div>
                <!-- Feature Card 2 -->
                <div class="resource-card resource-card-top-border-green">
                    <div class="p-6">
                        <div class="flex items-center mb-3"><span class="resource-tag resource-tag-video">VIDEO</span><span class="resource-tag-level resource-tag-level-beginner ml-auto">Pemula</span></div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Mengelola Jadwal dengan Kalender</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Tutorial video menggunakan kalender akademik terintegrasi untuk mengatur jadwal kuliah dan agenda penting.</p>
                        <div class="flex justify-between items-center text-sm text-gray-500"><span><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.414-1.415L11 9.586V6z" clip-rule="evenodd" /></svg>10 min video</span><a href="#" class="font-semibold text-green-600 hover:text-green-700 transition-colors">Tonton Sekarang <span aria-hidden="true">&rarr;</span></a></div>
                    </div>
                </div>
                <!-- Feature Card 3 -->
                <div class="resource-card resource-card-top-border-purple">
                     <div class="p-6">
                        <div class="flex items-center mb-3"><span class="resource-tag resource-tag-course">KURSUS</span><span class="resource-tag-level resource-tag-level-all ml-auto">Semua Level</span></div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">AWBIT di Mana Saja</h3>
                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">Modul singkat tentang cara mengakses AWBIT dengan nyaman dari laptop, tablet, atau smartphone Anda.</p>
                        <div class="flex justify-between items-center text-sm text-gray-500"><span><svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline mr-1" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.414-1.415L11 9.586V6z" clip-rule="evenodd" /></svg>15 min</span><a href="#" class="font-semibold text-purple-600 hover:text-purple-700 transition-colors">Pelajari Sekarang <span aria-hidden="true">&rarr;</span></a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-gray-800 text-gray-300 pt-20 pb-12 relative z-0 animate-on-scroll">
        <div class="container mx-auto px-4 sm:px-6 text-center">
            <p>&copy; <span id="currentYear"></span> AWBIT. Hak Cipta Dilindungi.</p>
            <div class="mt-4 space-x-4">
                <a href="#" class="hover:text-white text-sm">Kebijakan Privasi</a>
                <a href="#" class="hover:text-white text-sm">Syarat & Ketentuan</a>
                <a href="#" class="hover:text-white text-sm">Kontak Kami</a>
            </div>
        </div>
    </footer>

    <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 overflow-y-auto h-full w-full flex items-center justify-center z-50 hidden transition-opacity duration-300 ease-in-out opacity-0">
        <div class="relative mx-auto p-6 border w-11/12 sm:w-full max-w-md shadow-2xl rounded-xl bg-white transform transition-all duration-300 ease-in-out scale-95">
            <button id="closeModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
            <div class="mt-3 text-center">
                <h3 class="text-2xl leading-6 font-bold text-gray-900" id="modalTitle">Login ke AWBIT</h3>
                <div class="mt-4 px-2 sm:px-7 py-3">
                    {{-- Form login sekarang menggunakan form Laravel --}}
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        
                        {{-- Menampilkan error validasi umum --}}
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                        <x-input-error :messages="$errors->get('email')" class="mb-4 text-red-600 text-sm" />
                        
                        <input type="email" name="email" :value="old('email')" placeholder="Alamat Email" class="mb-4 px-4 py-3 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full text-sm" required autofocus>
                        <input type="password" name="password" placeholder="Password" class="mb-4 px-4 py-3 text-gray-700 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full text-sm" required>
                        
                        <div class="flex items-center justify-between mb-4">
                            <label for="remember_me_modal" class="inline-flex items-center">
                                <input id="remember_me_modal" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
                                <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
                            </label>
                             <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Lupa password?</a>
                        </div>

                        <button type="submit" class="bg-blue-600 text-white font-semibold py-3 px-5 rounded-lg shadow-md transform transition-all duration-300 ease-in-out hover:bg-blue-700 hover:shadow-lg hover:scale-105 hover:-translate-y-0.5 hover:brightness-110 w-full text-base">Login</button>

                        <div class="mt-6 text-sm">
                            <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:underline">Belum punya akun? Daftar sekarang</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            document.getElementById('currentYear').textContent = new Date().getFullYear();
            
            // Modal Logic
            const loginModal = document.getElementById('loginModal');
            const closeModalButton = document.getElementById('closeModal');

            window.showLoginModal = function() {
                loginModal.classList.remove('hidden');
                setTimeout(() => {
                    loginModal.classList.remove('opacity-0');
                    loginModal.querySelector('.transform').classList.remove('scale-95');
                }, 10);
            }

            window.hideLoginModal = function() {
                loginModal.classList.add('opacity-0');
                loginModal.querySelector('.transform').classList.add('scale-95');
                setTimeout(() => {
                    loginModal.classList.add('hidden');
                }, 300);
            }

            closeModalButton.addEventListener('click', hideLoginModal);
            window.addEventListener('click', (event) => {
                if (event.target === loginModal) {
                    hideLoginModal();
                }
            });

            // Scroll Reveal Animation Logic
            const sectionsToAnimate = document.querySelectorAll('.animate-on-scroll');
            const observerOptions = { root: null, rootMargin: '0px', threshold: 0.1 };
            const observerCallback = (entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target); 
                    }
                });
            };
            const scrollObserver = new IntersectionObserver(observerCallback, observerOptions);
            sectionsToAnimate.forEach(section => { scrollObserver.observe(section); });
        });
    </script>
</body>
</html>
