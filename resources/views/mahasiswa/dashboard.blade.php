<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AWBIT - Dashboard Mahasiswa</title>
    {{-- Aset dari file mahasiswa.html --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8; /* A cooler, softer gray */
        }
        .sidebar {
            background-color: #111827; /* A deep, dark gray */
        }
        .sidebar-item:hover {
            background-color: #1f2937; /* Slightly lighter dark gray */
        }
        .sidebar-item.active {
            background-color: #1f2937;
            color: white;
            font-weight: 600;
            border-left: 4px solid #38bdf8; /* sky-400 */
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .content-section {
            animation: fadeIn 0.5s ease-out forwards;
        }

        /* Kelas untuk badge dinamis */
        .badge-pemula { background-color: #bfdbfe; color: #1e40af; }
        .badge-aktif { background-color: #a7f3d0; color: #047857; }
        .badge-teladan { background-color: #fde68a; color: #92400e; }
        .badge-sipaling-rajin { background-color: #f9a8d4; color: #9d174d; }
    </style>
</head>
<body class="flex">

    <aside class="sidebar text-gray-300 w-72 min-h-screen p-4 flex flex-col fixed md:relative transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 z-30" id="sidebar">
        <div class="flex flex-col items-center space-y-3 p-4 text-center">
            <div class="relative">
                <img src="{{ Auth::user()->profile_photo_url }}" alt="Foto Profil Mahasiswa" class="w-28 h-28 rounded-full object-cover border-4 border-gray-700">
            </div>
            <h2 class="text-xl font-bold text-white">{{ Auth::user()->name }}</h2>
            <div id="student-badge-container">
                {{-- Badge Mahasiswa Dinamis --}}
                @if($currentBadge)
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full badge-{{ Str::slug($currentBadge->name) }}"><i class="fas fa-medal mr-1"></i> {{ $currentBadge->name }}</span>
                @else
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full badge-pemula"><i class="fas fa-seedling mr-1"></i> Pemula</span>
                @endif
            </div>
        </div>
        
        <nav class="flex-grow space-y-2 mt-6">
            <a href="#dashboard" id="nav-dashboard" class="sidebar-item flex items-center space-x-4 p-3 rounded-lg transition-colors duration-150 active">
                <i class="fas fa-home fa-fw w-6 text-center"></i>
                <span>Dashboard</span>
            </a>
            <a href="#pertemuan-kelas" id="nav-pertemuan-kelas" class="sidebar-item flex items-center space-x-4 p-3 rounded-lg transition-colors duration-150">
                <i class="fas fa-chalkboard fa-fw w-6 text-center"></i>
                <span>Pertemuan Kelas</span>
            </a>
            <a href="#forum-chat" id="nav-forum-chat" class="sidebar-item flex items-center space-x-4 p-3 rounded-lg transition-colors duration-150">
                <i class="fas fa-comments fa-fw w-6 text-center"></i>
                <span>Forum Diskusi</span>
            </a>
            <a href="#leaderboard" id="nav-leaderboard" class="sidebar-item flex items-center space-x-4 p-3 rounded-lg transition-colors duration-150">
                <i class="fas fa-trophy fa-fw w-6 text-center"></i>
                <span>Leaderboard</span>
            </a>
            <a href="#notifikasi" id="nav-notifikasi" class="sidebar-item flex items-center space-x-4 p-3 rounded-lg transition-colors duration-150 relative">
                <i class="fas fa-bell fa-fw w-6 text-center"></i>
                <span>Notifikasi</span>
                {{-- Notifikasi Badge Dinamis --}}
                @if($unreadNotificationsCount > 0)
                    <span class="absolute top-1/2 -translate-y-1/2 right-4 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">{{ $unreadNotificationsCount }}</span>
                @endif
            </a>
        </nav>
        <div class="mt-auto">
             <a href="{{ route('profile.edit') }}" class="sidebar-item flex items-center space-x-4 p-3 rounded-lg transition-colors duration-150 text-gray-400 hover:text-white">
                <i class="fas fa-user-cog fa-fw w-6 text-center"></i>
                <span>Pengaturan Akun</span>
            </a>
            {{-- Form Logout yang aman --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="sidebar-item flex items-center space-x-4 p-3 rounded-lg transition-colors duration-150 text-red-500 hover:bg-red-500 hover:text-white">
                    <i class="fas fa-sign-out-alt fa-fw w-6 text-center"></i>
                    <span>Logout</span>
                </a>
            </form>
        </div>
    </aside>

    <main class="flex-1 p-6 md:p-8 lg:p-10 transition-all duration-300 ease-in-out">
        <button id="sidebar-toggle" class="md:hidden fixed top-4 left-4 z-20 bg-gray-800 text-white p-2 rounded-md">
            <i class="fas fa-bars"></i>
        </button>

        <div id="content-area" class="mt-12 md:mt-0">
            <section id="dashboard-content" class="content-section space-y-8">
                <div>
                    {{-- Nama Mahasiswa Dinamis --}}
                    <h1 class="text-4xl font-extrabold text-gray-800">Helloo, {{ strtok(Auth::user()->name, ' ') }}!</h1>
                    <p class="text-gray-500 mt-2 text-lg">Siap untuk menaklukkan tantangan hari ini?</p>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 p-8 rounded-2xl bg-gradient-to-br from-gray-800 to-gray-900 text-white shadow-2xl flex flex-col justify-between">
                        <div>
                            <p class="text-xl font-medium text-sky-300">Total Kelas Diikuti</p>
                            <h2 class="text-3xl font-bold mt-2">{{ $enrolledCourses->count() }} Kelas Aktif</h2>
                        </div>
                        <div class="mt-6">
                            <div class="flex justify-between items-center text-gray-300 mb-1">
                                <span>Progress Pembelajaran Umum</span>
                                <span>{{ number_format($learningProgress, 0) }}%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-3">
                                <div class="bg-sky-400 h-3 rounded-full" style="width: {{ $learningProgress }}%"></div>
                            </div>
                            <a href="#pertemuan-kelas" class="inline-block mt-6 bg-sky-500 hover:bg-sky-400 text-white font-bold py-3 px-6 rounded-lg transition-colors">
                                Lihat Kelas <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
                             <div class="flex items-center space-x-4">
                                <div class="bg-red-100 text-red-600 w-12 h-12 flex items-center justify-center rounded-xl">
                                    <i class="fas fa-calendar-alt fa-lg"></i>
                                </div>
                                <div>
                                    {{-- Info Tugas Berikutnya Dinamis --}}
                                    @if($nextAssignment)
                                        <p class="text-gray-500 text-sm">Tugas Berikutnya</p>
                                        <p class="font-bold text-gray-800">Deadline: {{ $nextAssignment->due_date->diffForHumans() }}</p>
                                    @else
                                        <p class="font-bold text-gray-800">Tidak ada tugas</p>
                                        <p class="text-gray-500 text-sm">Waktunya bersantai!</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                         <div class="p-6 bg-white rounded-2xl shadow-lg border border-gray-100">
                            <div class="flex items-center space-x-4">
                                <div class="bg-amber-100 text-amber-600 w-12 h-12 flex items-center justify-center rounded-xl">
                                    <i class="fas fa-star fa-lg"></i>
                                </div>
                                <div>
                                    <p class="text-gray-500 text-sm">Total Poin Anda</p>
                                    <p class="font-bold text-gray-800">{{ number_format($totalPoints) }} Poin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Pencapaian Saya</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        {{-- Data pencapaian ini perlu disiapkan dari controller --}}
                        <div class="text-center p-4 bg-white rounded-xl shadow-md border border-gray-100">
                            <i class="fas fa-book-reader text-3xl text-sky-500"></i>
                            <p class="font-semibold mt-2">15 Modul</p>
                            <p class="text-xs text-gray-500">Selesai</p>
                        </div>
                        <div class="text-center p-4 bg-white rounded-xl shadow-md border border-gray-100">
                             <i class="fas fa-award text-3xl text-amber-500"></i>
                            <p class="font-semibold mt-2">{{ $student->badges->count() }} Lencana</p>
                            <p class="text-xs text-gray-500">Diperoleh</p>
                        </div>
                        <div class="text-center p-4 bg-white rounded-xl shadow-md border border-gray-100">
                             <i class="fas fa-clipboard-check text-3xl text-green-500"></i>
                            <p class="font-semibold mt-2">8 Tugas</p>
                            <p class="text-xs text-gray-500">Terkumpul</p>
                        </div>
                         <div class="text-center p-4 bg-white rounded-xl shadow-md border border-gray-100">
                            <i class="fas fa-running text-3xl text-indigo-500"></i>
                            <p class="font-semibold mt-2">5 Hari</p>
                            <p class="text-xs text-gray-500">Belajar Beruntun</p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="pertemuan-kelas-content" style="display: none;" class="content-section space-y-6">
                <h1 class="text-3xl font-bold text-gray-800">Pertemuan Kelas</h1>
                <p class="text-gray-500">Akses materi, kerjakan kuis, dan kumpulkan tugas di sini.</p>
                @forelse($enrolledCourses as $course)
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <h2 class="text-xl font-bold text-slate-800">{{ $course->name }}</h2>
                        <p class="text-sm text-slate-500">Dosen: {{ $course->lecturer->name }}</p>
                        <div class="mt-4 border-t pt-4">
                            <p>Daftar section, materi, dan tugas akan ditampilkan di sini...</p>
                            <a href="#" class="text-sky-600 font-semibold hover:underline">Masuk ke Kelas &rarr;</a>
                        </div>
                    </div>
                @empty
                    <p class="bg-white p-6 rounded-xl shadow-md text-center text-gray-500">Anda belum terdaftar di kelas manapun.</p>
                @endforelse
            </section>
            
            <section id="forum-chat-content" style="display: none;" class="content-section bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                <h1 class="text-3xl font-bold text-gray-800">Forum Diskusi</h1>
                <p class="text-gray-500 mt-2">Tempat untuk berdiskusi dengan dosen dan mahasiswa lain.</p>
                 </section>
            
            <section id="leaderboard-content" style="display: none;" class="content-section bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                <h1 class="text-3xl font-bold text-gray-800">Leaderboard - {{ $firstCourseName }}</h1>
                <p class="text-gray-500 mt-2">Lihat posisimu di antara teman-temanmu! (Data dari kelas pertama Anda)</p>
                <ol class="mt-6 space-y-4">
                    @forelse($leaderboard as $rank => $rankedStudent)
                    <li class="flex items-center justify-between p-4 rounded-lg {{ $rankedStudent->id == Auth::id() ? 'bg-sky-100 border-2 border-sky-500' : 'bg-gray-50' }}">
                        <div class="flex items-center gap-4">
                            <span class="font-bold text-lg text-gray-500 w-6 text-center">{{ $rank + 1 }}</span>
                            <img src="{{ $rankedStudent->profile_photo_url }}" class="w-10 h-10 rounded-full object-cover">
                            <span class="font-semibold text-gray-800">{{ $rankedStudent->name }}</span>
                        </div>
                        <span class="font-bold text-lg text-amber-600">{{ number_format($rankedStudent->points_sum) }} Poin</span>
                    </li>
                    @empty
                        <p class="text-center text-gray-500">Belum ada data poin untuk ditampilkan.</p>
                    @endforelse
                </ol>
            </section>

            <section id="notifikasi-content" style="display: none;" class="content-section bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                <h1 class="text-3xl font-bold text-gray-800">Notifikasi</h1>
                {{-- Loop untuk menampilkan notifikasi --}}
                @forelse (Auth::user()->unreadNotifications as $notification)
                    <div class="border-b py-4">
                        <p>{{ $notification->data['message'] ?? 'Notifikasi baru.' }}</p>
                        <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 mt-4">Tidak ada notifikasi baru.</p>
                @endforelse
            </section>
        </div>
    </main>

    {{-- Script dari file mahasiswa.html --}}
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const navLinks = document.querySelectorAll('.sidebar-item');
        const contentSections = document.querySelectorAll('#content-area > section');

        function showContent(targetId) {
            contentSections.forEach(section => {
                section.style.display = 'none';
            });
            const activeSection = document.getElementById(targetId + '-content');
            if (activeSection) {
                activeSection.style.display = 'block';
            }

            navLinks.forEach(link => link.classList.remove('active'));
            const activeLink = document.getElementById(`nav-${targetId}`);
            if (activeLink) {
                activeLink.classList.add('active');
            }
        }

        sidebarToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            sidebar.classList.toggle('-translate-x-full');
        });

        document.addEventListener('click', (e) => {
            if (window.innerWidth < 768 && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });

        navLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                const href = link.getAttribute('href');
                if (href && href.startsWith('#') && !link.closest('form')) {
                    e.preventDefault();
                    const targetId = href.substring(1);
                    window.location.hash = targetId;
                    if (window.innerWidth < 768) {
                        sidebar.classList.add('-translate-x-full');
                    }
                }
            });
        });

        function handleHashChange() {
            const hash = window.location.hash.substring(1) || 'dashboard';
            // Menambahkan semua ID navigasi yang valid
            const validHashes = ['dashboard', 'pertemuan-kelas', 'forum-chat', 'pengumpulan-poin', 'leaderboard', 'notifikasi', 'progress', 'pengaturan'];
            if(validHashes.includes(hash)) {
                showContent(hash);
            } else {
                showContent('dashboard');
            }
        }

        window.addEventListener('DOMContentLoaded', handleHashChange);
        window.addEventListener('hashchange', handleHashChange);
    </script>
</body>
</html>