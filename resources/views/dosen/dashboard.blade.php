<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AWBIT - Dashboard Dosen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc; /* slate-50 */
        }
        .sidebar {
            background-color: #074a6c; /* Warna dari desain lama Anda */
        }
        .sidebar-item:hover, .submenu-item:hover {
            background-color: #334155; /* slate-700 */
        }
        /* Menggunakan gaya 'active' dari desain baru */
        .sidebar-item.active {
            background-color: #3675ce; /* sky-500 */
            color: white;
            font-weight: 600;
        }
        .submenu-item.active {
            color: #38bdf8; /* sky-400 */
            background-color: #1e3a8a; /* sedikit lebih gelap untuk sub-menu */
        }
        .card-icon-container {
            transition: transform 0.3s ease-in-out;
        }
        .stat-card:hover .card-icon-container {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="flex" x-data="{ isSettingsModalOpen: false }">
     @include('partials.settings-modal')

    <aside class="sidebar text-slate-200 w-72 min-h-screen p-4 space-y-4 fixed md:relative transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 z-30" id="sidebar">
        <div class="flex flex-col items-center space-y-2 p-4 border-b border-slate-700">
            <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random&color=fff' }}" alt="Foto Profil {{ Auth::user()->name }}" class="w-24 h-24 rounded-full object-cover border-2 border-slate-500">
            <h2 class="text-lg font-semibold text-white">{{ Auth::user()->name }}</h2>
            <span class="text-sm bg-sky-500 text-white px-2 py-0.5 rounded-full font-medium capitalize">{{ Auth::user()->role->name }}</span>
            <a href="{{ route('profile.edit') }}" class="text-xs text-sky-300 hover:text-white mt-2">Edit Profil</a>
        </div>
        
        <div class="text-center py-2">
            <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-white tracking-wider">AWBIT</a>
        </div>
        
        <nav class="space-y-2">
            <a href="#dashboard" id="nav-dashboard" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-colors duration-150 active">
                <i class="fas fa-tachometer-alt w-5 h-5"></i>
                <span>Dashboard</span>
            </a>

            <div>
                <button id="data-master-toggle" class="sidebar-item w-full flex items-center justify-between space-x-3 p-3 rounded-lg transition-colors duration-150">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-chalkboard-teacher w-5 h-5"></i>
                        <span>Kelas Saya</span>
                    </div>
                    <i class="fas fa-chevron-down transform transition-transform duration-300" id="data-master-arrow"></i>
                </button>
                <div id="data-master-submenu" class="pl-6 mt-1 space-y-1 hidden">
                    <a href="{{ route('dosen.materials.index') }}" id="nav-media-pembelajaran" class="submenu-item flex items-center space-x-3 p-2 rounded-md text-slate-300">
                        <i class="fas fa-book-open w-4 h-4"></i>
                        <span>Media Pembelajaran</span>
                    </a>
                    <a href="#section" id="nav-section" class="submenu-item flex items-center space-x-3 p-2 rounded-md text-slate-300">
                        <i class="fas fa-sitemap w-4 h-4"></i>
                        <span>Section Pertemuan</span>
                    </a>
                    <a href="#assignment" id="nav-assignment" class="submenu-item flex items-center space-x-3 p-2 rounded-md text-slate-300">
                        <i class="fas fa-file-alt w-4 h-4"></i>
                        <span>Assignment (Tugas)</span>
                    </a>
                    <a href="#mahasiswa" id="nav-mahasiswa" class="submenu-item flex items-center space-x-3 p-2 rounded-md text-slate-300">
                        <i class="fas fa-users w-4 h-4"></i>
                        <span>Mahasiswa Kelas</span>
                    </a>
                    <a href="#penilaian" id="nav-penilaian" class="submenu-item flex items-center space-x-3 p-2 rounded-md text-slate-300">
                        <i class="fas fa-clipboard-check w-4 h-4"></i>
                        <span>Penilaian</span>
                    </a>
                    <a href="#forum" id="nav-forum" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-colors duration-150">
    <i class="fas fa-comments w-5 h-5"></i>
    <span>Forum Diskusi</span>
</a>
                </div>
            </div>
            
            <a href="#pengaturan" id="nav-pengaturan" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-colors duration-150">
                <i class="fas fa-cog w-5 h-5"></i>
                <span>Pengaturan</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-colors duration-150 mt-auto text-red-400 hover:bg-red-500 hover:text-white">
                    <i class="fas fa-sign-out-alt w-5 h-5"></i>
                    <span>Logout</span>
                </a>
            </form>
        </nav>
    </aside>

    <main class="flex-1 p-6 md:p-10 transition-all duration-300 ease-in-out">
        <button id="sidebar-toggle" class="md:hidden fixed top-4 left-4 z-20 bg-slate-800 text-white p-2 rounded-md">
            <i class="fas fa-bars"></i>
        </button>

        <div id="content-area" class="mt-12 md:mt-0">
            <section id="dashboard-content" class="space-y-8">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800">Haloo, {{ Auth::user()->name }}!</h1>
                    <p class="text-slate-500 mt-1">Berikut adalah ringkasan aktivitas mengajar Anda.</p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Mahasiswa</p>
                                <p class="text-4xl font-bold text-slate-800 mt-1">{{ $totalStudents ?? 0 }}</p>
                            </div>
                            <div class="card-icon-container bg-sky-100 text-sky-600 p-4 rounded-full">
                                <i class="fas fa-user-graduate fa-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Kelas Aktif</p>
                                <p class="text-4xl font-bold text-slate-800 mt-1">{{ $activeCoursesCount ?? 0 }}</p>
                            </div>
                             <div class="card-icon-container bg-teal-100 text-teal-600 p-4 rounded-full">
                                <i class="fas fa-chalkboard-teacher fa-lg"></i>
                            </div>
                        </div>
                    </div>
                    <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300">
                         <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Tugas Perlu Dinilai</p>
                                <p class="text-4xl font-bold text-slate-800 mt-1">{{ $pendingSubmissionsCount ?? 0 }}</p>
                            </div>
                           <div class="card-icon-container bg-amber-100 text-amber-600 p-4 rounded-full">
                                <i class="fas fa-file-signature fa-lg"></i>
                            </div>
                        </div>
                    </div>
                     <div class="stat-card bg-white p-6 rounded-xl shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-300">
                         <div class="flex justify-between items-center">
                            <div>
                                <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Materi / Modul</p>
                                {{-- Pastikan variabel $materialsCount dikirim dari Controller Anda --}}
                                <p class="text-4xl font-bold text-slate-800 mt-1">{{ $materialsCount ?? 0 }}</p>
                            </div>
                            <div class="card-icon-container bg-violet-100 text-violet-600 p-4 rounded-full">
                                <i class="fas fa-book-atlas fa-lg"></i>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold text-slate-800">Status Kelas Anda</h2>
                        <a href="{{ route('dosen.kelas.create') }}" class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-plus mr-2"></i>Ajukan Kelas Baru
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="border-b">
                                <tr>
                                    <th class="py-2 px-4">Nama Kelas</th>
                                    <th class="py-2 px-4">Kode</th>
                                    <th class="py-2 px-4">Status</th>
                                    <th class="py-2 px-4">Tanggal Diajukan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($courses as $course)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="py-3 px-4">{{ $course->name }}</td>
                                    <td class="py-3 px-4">{{ $course->course_code }}</td>
                                    <td class="py-3 px-4">
                                        @if($course->status == 'approved')
                                            <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-200 rounded-full">Disetujui</span>
                                        @elseif($course->status == 'pending')
                                            <span class="px-2 py-1 text-xs font-semibold text-yellow-800 bg-yellow-200 rounded-full">Menunggu</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-200 rounded-full">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">{{ $course->created_at->format('d M Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-slate-500">Anda belum memiliki kelas. Silakan ajukan kelas baru.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="media-pembelajaran-content" style="display: none;" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <h1 class="text-3xl font-semibold text-slate-800">Media Pembelajaran</h1>
                <p class="mt-2 text-slate-600">Kelola modul, video, dan presentasi. Pilih kelas untuk melihat materinya.</p>
                <div class="mt-4">
                    <label for="media-course-filter" class="block text-sm font-medium text-gray-700">Pilih Kelas:</label>
                    <select id="media-course-filter" class="mt-1 block w-full md:w-1/3 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach($courses->where('status', 'approved') as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="mt-4 bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">
                    <i class="fas fa-plus mr-2"></i>Tambah Media
                </button>
            </section>

<section id="section-content" style="display: none;" class="content-section bg-white p-6 rounded-xl shadow-sm border border-gray-200">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-semibold text-slate-800">Section Pertemuan</h1>
        <a href="{{ route('dosen.sections.create') }}" class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">
            <i class="fas fa-plus mr-2"></i>Tambah Section Baru
        </a>
    </div>
    <p class="mt-2 text-slate-600">Atur jadwal dan detail pertemuan mingguan untuk setiap kelas.</p>

    {{-- Daftar Section per Kelas --}}
    <div class="mt-6 space-y-8">
        @foreach($courses->where('status', 'approved') as $course)
            <div class="p-4 border rounded-lg">
                <h3 class="font-bold text-lg text-slate-700 mb-2">Kelas: {{ $course->name }}</h3>
                <table class="w-full text-left text-sm">
                    <thead class="border-b bg-gray-50">
                        <tr>
                            <th class="p-2">Minggu Ke-</th>
                            <th class="p-2">Judul Section</th>
                            <th class="p-2">Tanggal</th>
                            <th class="p-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
    @forelse($course->sections as $section)
    <tr class="border-b">
        <td class="p-2 w-24">{{ $section->week_number }}</td>
        <td class="p-2 font-medium">{{ $section->title }}</td>
        <td class="p-2">{{ \Carbon\Carbon::parse($section->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($section->end_date)->format('d M Y') }}</td>
        <td class="p-2 text-center">
            {{-- Tombol Edit, sekarang mengarah ke route 'edit' --}}
            <a href="{{ route('dosen.sections.edit', $section->id) }}" class="text-yellow-500 hover:text-yellow-700 p-1" title="Edit"><i class="fas fa-edit"></i></a>
            
            {{-- Tombol Hapus, sekarang ada di dalam form yang aman --}}
            <form action="{{ route('dosen.sections.destroy', $section->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Anda yakin ingin menghapus section ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-700 p-1" title="Hapus"><i class="fas fa-trash"></i></button>
            </form>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="4" class="p-4 text-center text-gray-400">Belum ada section untuk kelas ini.</td>
    </tr>
    @endforelse
</tbody>
                </table>
            </div>
        @endforeach
    </div>
</section>
            
<section id="assignment-content" style="display: none;" class="content-section bg-white p-6 rounded-xl shadow-sm border border-gray-200">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-semibold text-slate-800">Assignment (Tugas & Kuis)</h1>
        <a href="#" class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">
            <i class="fas fa-plus mr-2"></i>Buat Assignment Baru
        </a>
    </div>
    <p class="mt-2 text-slate-600">Buat dan kelola tugas untuk setiap section pertemuan.</p>

    <div class="mt-6 space-y-8">
        @foreach($courses->where('status', 'approved') as $course)
            <div class="p-4 border rounded-lg">
                <h3 class="font-bold text-lg text-slate-700 mb-2">Kelas: {{ $course->name }}</h3>
                @if($course->sections->isEmpty())
                    <p class="p-4 text-center text-gray-400">Buat section terlebih dahulu untuk menambahkan assignment.</p>
                @else
                    @foreach($course->sections as $section)
                        <div class="pl-4 mt-2">
                            <h4 class="font-semibold text-md text-slate-600">Section: {{ $section->title }}</h4>
                            <ul class="list-disc pl-5 mt-1 space-y-1">
                                @forelse($section->assignments as $assignment)
                                    <li class="text-sm flex justify-between items-center">
                                        <span>{{ $assignment->title }} ({{ $assignment->type }}) - <span class="text-red-600">Deadline: {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M Y, H:i') }}</span></span>
                                        <div>
                                            <a href="#" class="text-yellow-500 hover:text-yellow-700 p-1" title="Edit"><i class="fas fa-edit"></i></a>
                                            <button class="text-red-500 hover:text-red-700 p-1" title="Hapus"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-gray-400 text-sm italic">Belum ada assignment di section ini.</li>
                                @endforelse
                            </ul>
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
    </div>
</section>

<section id="mahasiswa-content" style="display: none;" class="content-section bg-white p-6 rounded-xl shadow-sm border border-gray-200">
    <h1 class="text-3xl font-semibold text-slate-800">Mahasiswa Kelas</h1>
    <p class="mt-2 text-slate-600">Lihat data mahasiswa yang terdaftar di kelas Anda.</p>
    
    <div class="mt-6 space-y-8">
        @foreach($courses->where('status', 'approved') as $course)
            <div class="p-4 border rounded-lg">
                <h3 class="font-bold text-lg text-slate-700 mb-2">Kelas: {{ $course->name }} ({{ $course->students->count() }} Mahasiswa)</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="border-b bg-gray-50">
                            <tr>
                                <th class="p-2">Nama</th>
                                <th class="p-2">NIM</th>
                                <th class="p-2">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($course->students as $student)
                            <tr class="border-b">
                                <td class="p-2 font-medium">{{ $student->name }}</td>
                                <td class="p-2">{{ $student->nim_nidn }}</td>
                                <td class="p-2">{{ $student->email }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center text-gray-400">Belum ada mahasiswa terdaftar di kelas ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
</section>

<section id="penilaian-content" style="display: none;" class="content-section bg-white p-6 rounded-xl shadow-sm border border-gray-200">
    <h1 class="text-3xl font-semibold text-slate-800">Penilaian Tugas Mahasiswa</h1>
    <p class="mt-2 text-slate-600">Lihat, nilai, dan berikan feedback untuk tugas yang telah dikumpulkan.</p>
    
    <div class="mt-6 space-y-8">
        @foreach($courses->where('status', 'approved') as $course)
            <div class="p-4 border rounded-lg">
                <h3 class="font-bold text-lg text-slate-700 mb-2">Kelas: {{ $course->name }}</h3>
                <table class="w-full text-left text-sm">
                    <thead class="border-b bg-gray-50">
                        <tr>
                            <th class="p-2">Judul Tugas</th>
                            <th class="p-2 text-center">Total Pengumpul</th>
                            <th class="p-2 text-center">Perlu Dinilai</th>
                            <th class="p-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
@php
    $assignments = $course->sections->flatMap(function ($section) {
        return $section->assignments;
    });
@endphp
                        @forelse($assignments as $assignment)
                        <tr class="border-b">
                            <td class="p-2 font-medium">{{ $assignment->title }}</td>
                            <td class="p-2 text-center">{{ $assignment->submissions->count() }}</td>
                            <td class="p-2 text-center font-bold text-red-500">{{ $assignment->submissions->whereNull('grade')->count() }}</td>
                            <td class="p-2 text-center">
                                <a href="#" class="bg-blue-500 text-white px-3 py-1 text-xs rounded-full hover:bg-blue-600">Lihat & Nilai</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-400">Belum ada assignment untuk dinilai di kelas ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
</section>

<section id="pengaturan-content" style="display: none;" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
    <h1 class="text-3xl font-semibold text-slate-800">Pengaturan Akun</h1>
    <p class="mt-4 text-slate-600">
        Anda dapat mengubah informasi profil, kata sandi, dan mengelola sesi login melalui halaman
        <a href="{{ route('profile.edit') }}" class="text-sky-500 hover:underline">Edit Profil</a>.
    </p>
</section>

<section id="forum-content" style="display: none;" class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-semibold text-slate-800">Forum Diskusi</h1>
        <button class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded-lg transition-colors">
            <i class="fas fa-plus mr-2"></i>Buat Topik Baru
        </button>
    </div>
    <p class="mt-2 text-slate-600">Pilih kelas untuk melihat forum diskusi.</p>
    <div class="mt-6 space-y-4">
        @forelse ($courses->where('status', 'approved') as $course)
            <a href="#" class="block p-4 border rounded-lg hover:bg-gray-50 hover:border-sky-500 transition-all">
                <h3 class="font-bold text-lg text-slate-800">{{ $course->name }}</h3>
                <p class="text-sm text-slate-500">
                    Total Topik: {{ $course->forumThreads->count() ?? 0 }}
                </p>
            </a>
        @empty
            <p class="text-slate-500">Belum ada forum yang tersedia. Kelas perlu disetujui terlebih dahulu.</p>
        @endforelse
    </div>
</section>

</div>
</main>

<script>
    const validHashes = ['dashboard', 'media-pembelajaran', 'section', 'mahasiswa', 'penilaian', 'pengaturan', 'assignment', 'forum'];
    const dataMasterToggle = document.getElementById('data-master-toggle');
    const dataMasterSubmenu = document.getElementById('data-master-submenu');
    const dataMasterArrow = document.getElementById('data-master-arrow');
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const navLinks = document.querySelectorAll('.sidebar-item, .submenu-item');
    const contentSections = document.querySelectorAll('#content-area > section');

    function showContent(targetId) {
        contentSections.forEach(section => {
            section.style.display = 'none';
        });
        const activeSection = document.getElementById(targetId + '-content');
        if (activeSection) {
            activeSection.style.display = 'block';
        }

        document.querySelectorAll('.sidebar-item, .submenu-item').forEach(item => item.classList.remove('active'));

        const activeLink = document.getElementById(`nav-${targetId}`);
        if (activeLink) {
            if (activeLink.classList.contains('sidebar-item')) {
                activeLink.classList.add('active');
            }
            const parentSubmenu = activeLink.closest('#data-master-submenu');
            if (parentSubmenu) {
                activeLink.classList.add('active');
            } else if (targetId !== 'dashboard') {
                dataMasterSubmenu.classList.add('hidden');
                dataMasterArrow.classList.remove('rotate-180');
            }
        }
    }

    dataMasterToggle.addEventListener('click', (e) => {
        e.preventDefault();
        dataMasterSubmenu.classList.toggle('hidden');
        dataMasterArrow.classList.toggle('rotate-180');
    });

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
            const isToggle = link.id === 'data-master-toggle';

            if (href && href.startsWith('#') && !isToggle && !link.closest('form')) {
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
        const validHashes = ['dashboard', 'media-pembelajaran', 'section', 'mahasiswa', 'penilaian', 'pengaturan', 'assignment', 'forum'];
        if (validHashes.includes(hash)) {
            showContent(hash);
        } else {
            showContent('dashboard');
        }

        const activeSubmenuLink = document.querySelector(`.submenu-item[href="#${hash}"]`);
        if (activeSubmenuLink) {
            dataMasterSubmenu.classList.remove('hidden');
            dataMasterArrow.classList.add('rotate-180');
        }
    }

    window.addEventListener('DOMContentLoaded', handleHashChange);
    window.addEventListener('hashchange', handleHashChange);
</script>
</body>
</html>