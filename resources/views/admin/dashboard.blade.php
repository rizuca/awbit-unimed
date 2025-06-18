<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AWBIT - Dasbor Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ url('css/custom-admin.css') }}">
    <script>
        // Logika untuk menerapkan tema gelap/terang sesegera mungkin untuk menghindari FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-item:hover, .submenu-item:hover { @apply bg-blue-500 text-white; }
        .sidebar-item.active { @apply bg-blue-600 text-white font-semibold; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { @apply bg-gray-100 dark:bg-slate-700; }
        ::-webkit-scrollbar-thumb { @apply bg-gray-400 dark:bg-slate-500 rounded-md; }
        ::-webkit-scrollbar-thumb:hover { @apply bg-gray-500 dark:bg-slate-400; }
        .content-section { animation: fadeIn 0.5s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .modal { transition: opacity 0.25s ease; }
        .modal-content { transition: transform 0.25s ease; }
    </style>
</head>
<body class="bg-gray-100 dark:bg-slate-900 flex">

    <aside class="bg-slate-800 dark:bg-gray-900 text-slate-100 w-72 min-h-screen p-4 space-y-4 fixed md:relative transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 z-30" id="sidebar">
        <div class="flex flex-col items-center space-y-3 p-4 border-b border-slate-700 dark:border-gray-700">
            <div class="relative">
                <img src="{{ $admin->profile_photo_path ? asset('storage/' . $admin->profile_photo_path) : 'https://placehold.co/100x100/E2E8F0/334155?text=' . substr($admin->name, 0, 1) }}" alt="Foto Profil Admin" class="w-24 h-24 rounded-full object-cover border-4 border-slate-600 dark:border-gray-600 shadow-lg">
                <span class="absolute bottom-1 right-1 bg-green-500 w-4 h-4 rounded-full border-2 border-slate-800 dark:border-gray-900"></span>
            </div>
            <h2 class="text-lg font-semibold text-white pt-2">{{ $admin->name }}</h2>
            <span class="text-xs font-semibold px-3 py-1 rounded-full bg-red-500 text-white shadow-md">{{ ucfirst($admin->role->name) }}</span>
        </div>

        <nav class="flex-grow space-y-1 overflow-y-auto" style="max-height: calc(100vh - 220px);">
            <a href="#dashboard" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-colors duration-150"><i class="fas fa-tachometer-alt w-5 h-5"></i><span>Dashboard</span></a>
            <a href="#dosen" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-colors duration-150"><i class="fas fa-chalkboard-teacher w-5 h-5"></i><span>Manajemen Dosen</span></a>
            <a href="#kelas" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-colors duration-150"><i class="fas fa-book-open w-5 h-5"></i><span>Manajemen Kelas</span></a>
            <a href="#buku" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-colors duration-150"><i class="fas fa-book-open w-5 h-5"></i><span>Manajemen Buku / Materi</span></a>
            <a href="#mahasiswa" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-colors duration-150"><i class="fas fa-users w-5 h-5"></i><span>Manajemen Mahasiswa</span></a>
            
            <div class="pt-4 border-t border-slate-700 dark:border-gray-700">
                <a href="#pengaturan" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-colors duration-150"><i class="fas fa-cog w-5 h-5"></i><span>Pengaturan</span></a>
                <button id="theme-toggle" class="sidebar-item w-full flex items-center space-x-3 p-3 rounded-lg transition-colors duration-150">
                    <i id="theme-toggle-dark-icon" class="fas fa-moon w-5 h-5 hidden"></i>
                    <i id="theme-toggle-light-icon" class="fas fa-sun w-5 h-5 hidden"></i>
                    <span>Ubah Tema</span>
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="sidebar-item flex items-center space-x-3 p-3 rounded-lg transition-colors duration-150 text-red-400 hover:bg-red-500 hover:text-white">
                        <i class="fas fa-sign-out-alt w-5 h-5"></i>
                        <span>Logout</span>
                    </a>
                </form>
            </div>
        </nav>
    </aside>

    <main class="flex-1 p-6 md:p-10 transition-all duration-300 ease-in-out">
        <button id="sidebar-toggle" class="md:hidden fixed top-4 left-4 z-40 bg-slate-800 text-white p-2 rounded-md"><i class="fas fa-bars"></i></button>

        <div id="content-area" class="mt-12 md:mt-0">
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" x-transition class="bg-green-100 border-l-4 border-green-500 text-green-700 dark:bg-green-900/50 dark:text-green-300 p-4 mb-6 rounded-lg shadow-md" role="alert">
                    <p class="font-bold">Sukses</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <section id="dashboard-content" class="content-section">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-6">Dashboard Admin</h1>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <a href="#dosen"><div class="bg-gradient-to-br from-sky-500 to-sky-600 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2 duration-300"><div class="flex justify-between items-center"><div><p class="text-lg font-medium">Total Dosen</p><p class="text-4xl font-bold">{{ $totalDosen }}</p></div><i class="fas fa-chalkboard-teacher fa-3x opacity-50"></i></div></div></a>
                    <a href="#mahasiswa"><div class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2 duration-300"><div class="flex justify-between items-center"><div><p class="text-lg font-medium">Total Mahasiswa</p><p class="text-4xl font-bold">{{ $totalMahasiswa }}</p></div><i class="fas fa-users fa-3x opacity-50"></i></div></div></a>
                    <a href="#kelas"><div class="bg-gradient-to-br from-amber-500 to-amber-600 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2 duration-300"><div class="flex justify-between items-center"><div><p class="text-lg font-medium">Total Kelas</p><p class="text-4xl font-bold">{{ $totalKelas }}</p></div><i class="fas fa-book-open fa-3x opacity-50"></i></div></div></a>
                    <a href="#buku"><div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:-translate-y-2 duration-300"><div class="flex justify-between items-center"><div><p class="text-lg font-medium">Total Materi/Buku</p><p class="text-4xl font-bold">{{ $totalMateri }}</p></div><i class="fas fa-book fa-3x opacity-50"></i></div></div></a>
                </div>
            </section>

            <section id="dosen-content" class="content-section hidden">
                <div class="bg-white dark:bg-slate-800 p-8 rounded-xl shadow-lg">
                    <div class="flex justify-between items-center mb-6"><h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">Manajemen Dosen</h1><button onclick="openAddDosenModal('addDosenModal')" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:scale-105"><i class="fas fa-plus mr-2"></i>Tambah Dosen Baru</button></div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-slate-700"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NIDN</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th><th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th></tr></thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($dosens as $dosen)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-white">{{ $dosen->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $dosen->nim_nidn ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $dosen->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center space-x-2">
                                        <button onclick='openEditDosenModal({{ json_encode($dosen) }})' class="text-indigo-600 hover:text-indigo-400 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">Edit</button>
                                        <button onclick='openDeleteDosenModal({{ $dosen->id }}, "{{ $dosen->name }}")' class="text-red-600 hover:text-red-400 dark:text-red-400 dark:hover:text-red-300 transition-colors">Hapus</button>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-6 text-gray-500 dark:text-gray-400">Belum ada data dosen.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="kelas-content" class="content-section hidden">
                <div class="bg-white dark:bg-slate-800 p-8 rounded-xl shadow-lg">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Manajemen Pengajuan Kelas</h1>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-slate-700"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Kelas</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Dosen Pengaju</th><th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th><th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th></tr></thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($kelasList as $kelas)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-white">{{ $kelas->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $kelas->lecturer->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center"><span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full @if($kelas->status == 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 @elseif($kelas->status == 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">{{ ucfirst($kelas->status) }}</span></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                                        @if($kelas->status == 'pending')
                                            <form method="POST" action="{{ route('admin.kelas.approve', $kelas) }}" class="inline-block"> @csrf @method('PATCH') <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-3 rounded-lg text-xs transition-all">Setujui</button></form>
                                            <form method="POST" action="{{ route('admin.kelas.reject', $kelas) }}" class="inline-block"> @csrf @method('PATCH') <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded-lg text-xs transition-all">Tolak</button></form>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500 italic">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-6 text-gray-500 dark:text-gray-400">Belum ada pengajuan kelas.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="buku-content" class="content-section hidden">
                <div class="bg-white dark:bg-slate-800 p-8 rounded-xl shadow-lg">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Manajemen Buku / Materi</h1>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-slate-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Judul Materi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipe</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Mata Kuliah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Dosen</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($materials as $material)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-white">{{ $material->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300"><span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">{{ ucfirst($material->type) }}</span></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $material->section->course->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $material->section->course->lecturer->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($material->file_path)
                                            <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-400 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">Lihat File</a>
                                        @else
                                            <span class="text-gray-400 italic">Tidak ada file</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-gray-500 dark:text-gray-400">Belum ada data materi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="mahasiswa-content" class="content-section hidden">
                <div class="bg-white dark:bg-slate-800 p-8 rounded-xl shadow-lg">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-6">Manajemen Mahasiswa</h1>
                    <form method="GET" action="{{ route('admin.dashboard') }}#mahasiswa" class="mb-6 bg-gray-50 dark:bg-slate-700 p-4 rounded-lg border dark:border-gray-600">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="search_mahasiswa" class="block text-md font-medium text-gray-700 dark:text-gray-300">Cari Nama Mahasiswa</label>
                                <input type="text" name="search_mahasiswa" id="search_mahasiswa" value="{{ $request->search_mahasiswa }}" placeholder="Ketik nama..." class="mt-1 py-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-slate-800 dark:text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="kelas_filter" class="block text-md font-medium text-gray-700 dark:text-gray-300">Filter Berdasarkan Kelas</label>
                                <select name="kelas_filter" id="kelas_filter" class="mt-1 py-2 block w-full border-gray-300 dark:border-gray-600 dark:bg-slate-800 dark:text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="all">Semua Kelas</option>
                                    @foreach($kelasList->where('status', 'approved') as $kelas)
                                        <option value="{{ $kelas->id }}" {{ $request->kelas_filter == $kelas->id ? 'selected' : '' }}>
                                            {{ $kelas->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="self-end">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg shadow-md">Cari</button>
                                <a href="{{ route('admin.dashboard') }}#mahasiswa" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white ml-2">Reset</a>
                            </div>
                        </div>
                    </form>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-slate-700"><tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NIM</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th><th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th></tr></thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-gray-700">
                               @forelse ($mahasiswas as $mahasiswa)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-white">{{ $mahasiswa->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">{{ $mahasiswa->nim_nidn ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $mahasiswa->status == 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">{{ ucfirst($mahasiswa->status) }}</span></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <form method="POST" action="{{ route('admin.mahasiswa.toggleStatus', $mahasiswa) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="font-bold py-1 px-3 rounded-lg text-xs transition-all {{ $mahasiswa->status == 'active' ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-green-500 hover:bg-green-600 text-white' }}">{{ $mahasiswa->status == 'active' ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                                        </form>
                                    </td>
                                </tr>
                               @empty
                                <tr><td colspan="4" class="text-center py-6 text-gray-500 dark:text-gray-400">Tidak ada mahasiswa yang cocok dengan pencarian.</td></tr>
                               @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            
            <section id="pengaturan-content" class="content-section hidden">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200 mb-6">Pengaturan Akun</h1>
                
                {{-- Formulir Tunggal untuk Semua Pengaturan --}}
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        {{-- Kartu Edit Profil --}}
                        <div class="bg-white dark:bg-slate-800 p-8 rounded-xl shadow-lg">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Edit Profil</h2>
                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $admin->name) }}" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-700 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-700 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>

                        {{-- Kartu Foto Profil --}}
                        <div class="bg-white dark:bg-slate-800 p-8 rounded-xl shadow-lg">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Foto Profil</h2>
                            <div x-data="{ photoName: null, photoPreview: null }">
                                <div class="col-span-6 sm:col-span-4">
                                    <input type="file" class="hidden" name="photo" x-ref="photo" x-on:change="
                                               photoName = $refs.photo.files[0].name;
                                               const reader = new FileReader();
                                               reader.onload = (e) => { photoPreview = e.target.result; };
                                               reader.readAsDataURL($refs.photo.files[0]);
                                    ">
                                    <div class="mt-2" x-show="! photoPreview">
                                        <img src="{{ $admin->profile_photo_path ? asset('storage/' . $admin->profile_photo_path) : 'https://placehold.co/400x400/E2E8F0/334155?text=' . substr($admin->name, 0, 1) }}" alt="{{ $admin->name }}" class="rounded-full h-40 w-40 object-cover mx-auto">
                                    </div>
                                    <div class="mt-2" x-show="photoPreview" style="display: none;">
                                        <span class="block rounded-full w-40 h-40 bg-cover bg-no-repeat bg-center mx-auto" x-bind:style="'background-image: url(\'' + photoPreview + '\');'"></span>
                                    </div>
                                    <div class="mt-6 text-center">
                                        <button type="button" class="bg-gray-200 dark:bg-slate-600 hover:bg-gray-300 dark:hover:bg-slate-500 text-gray-800 dark:text-white font-bold py-2 px-4 rounded-lg transition-all" x-on:click.prevent="$refs.photo.click()">
                                            Pilih Foto Baru 
                                    </div>
                                        </button>
                                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 text-center">Format: JPG, PNG. Maksimal 2MB.</p>
                                    @error('photo') <p class="text-red-500 text-xs mt-2 text-center">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Kartu Ubah Password --}}
                        <div class="lg:col-span-2 bg-white dark:bg-slate-800 p-8 rounded-xl shadow-lg">
                            <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Ubah Password</h2>
                             <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Kosongkan jika Anda tidak ingin mengubah password.</p>
                            <div class="space-y-4">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password Baru</label>
                                    <input type="password" name="password" id="password" autocomplete="new-password" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-700 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-700 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Simpan Terpusat --}}
                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i> Simpan Semua Perubahan
                        </button>
                    </div>
                </form>
            </section>

        </div> </main>

    <div id="dosenModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center modal" onclick="closeModal('dosenModal')">
        <div class="relative mx-auto p-8 border w-full max-w-lg shadow-2xl rounded-2xl bg-white dark:bg-slate-800 modal-content" onclick="event.stopPropagation();">
            <button onclick="closeModal('dosenModal')" class="absolute top-5 right-5 text-gray-400 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white transition"><i class="fas fa-times fa-lg"></i></button>
            <h3 id="dosenModalTitle" class="text-2xl font-bold text-gray-800 dark:text-white mb-6"></h3>
            <form id="dosenForm" method="POST" action="" class="space-y-4">
                @csrf
                <input type="hidden" name="_method" id="dosenFormMethod" value="POST">
                <div><label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap</label><input type="text" name="name" id="dosen_name" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-700 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></div>
                <div><label for="nim_nidn" class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIDN</label><input type="text" name="nim_nidn" id="dosen_nim_nidn" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-700 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></div>
                <div><label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat Email</label><input type="email" name="email" id="dosen_email" required class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-700 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"></div>
                <div><label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label><input type="password" name="password" id="dosen_password" class="mt-1 block w-full px-3 py-2 bg-white dark:bg-slate-700 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Kosongkan jika tidak diubah"></div>
                <div class="pt-4 flex justify-end space-x-3"><button type="button" onclick="closeModal('dosenModal')" class="bg-gray-200 dark:bg-slate-600 hover:bg-gray-300 dark:hover:bg-slate-500 text-gray-800 dark:text-white font-bold py-2 px-4 rounded-lg transition-all">Batal</button><button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition-all">Simpan</button></div>
            </form>
        </div>
    </div>

    <div id="deleteDosenModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 overflow-y-auto h-full w-full hidden z-50 flex items-center justify-center modal" onclick="closeModal('deleteDosenModal')">
        <div class="relative mx-auto p-8 border w-full max-w-md shadow-2xl rounded-2xl bg-white dark:bg-slate-800 modal-content" onclick="event.stopPropagation();">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/50"><i class="fas fa-exclamation-triangle fa-lg text-red-600 dark:text-red-400"></i></div>
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mt-5">Hapus Akun Dosen</h3>
                <div class="mt-2 px-7 py-3"><p class="text-sm text-gray-500 dark:text-gray-400">Anda yakin ingin menghapus akun dosen <strong id="deleteDosenName" class="text-gray-700 dark:text-white"></strong>? Aksi ini tidak dapat dibatalkan.</p></div>
                <div class="items-center px-4 py-3 space-x-4">
                    <button onclick="closeModal('deleteDosenModal')" class="bg-gray-200 dark:bg-slate-600 hover:bg-gray-300 dark:hover:bg-slate-500 text-gray-900 dark:text-white font-bold py-2 px-6 rounded-lg">Batal</button>
                    <form id="deleteDosenForm" method="POST" action="" class="inline-block">@csrf @method('DELETE')<button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg">Ya, Hapus</button></form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- Logika Modal ---
            window.openModal = function(modalId) { document.getElementById(modalId).classList.remove('hidden'); }
            window.closeModal = function(modalId) { document.getElementById(modalId).classList.add('hidden'); }
            
            window.openAddDosenModal = function() {
                document.getElementById('dosenModalTitle').innerText = 'Formulir Tambah Dosen';
                const form = document.getElementById('dosenForm');
                form.action = "{{ route('admin.dosen.store') }}";
                document.getElementById('dosenFormMethod').value = "POST";
                form.reset();
                document.getElementById('dosen_password').setAttribute('required', 'required');
                openModal('dosenModal');
            }

            window.openEditDosenModal = function(dosen) {
                document.getElementById('dosenModalTitle').innerText = 'Edit Data Dosen';
                const form = document.getElementById('dosenForm');
                form.action = `/admin/dosen/${dosen.id}`;
                document.getElementById('dosenFormMethod').value = "PATCH";
                document.getElementById('dosen_name').value = dosen.name;
                document.getElementById('dosen_nim_nidn').value = dosen.nim_nidn;
                document.getElementById('dosen_email').value = dosen.email;
                document.getElementById('dosen_password').removeAttribute('required');
                openModal('dosenModal');
            }

            window.openDeleteDosenModal = function(dosenId, dosenName) {
                document.getElementById('deleteDosenName').innerText = dosenName;
                document.getElementById('deleteDosenForm').action = `/admin/dosen/${dosenId}`;
                openModal('deleteDosenModal');
            }

            // --- Navigasi SPA ---
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const navLinks = document.querySelectorAll('.sidebar-item');
            const contentSections = document.querySelectorAll('.content-section');
            const contentArea = document.getElementById('content-area');

            sidebarToggle.addEventListener('click', (e) => { e.stopPropagation(); sidebar.classList.toggle('-translate-x-full'); });
            document.addEventListener('click', (e) => { if (window.innerWidth < 768 && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) { sidebar.classList.add('-translate-x-full'); } });

            function showContent(targetId) {
                contentArea.style.opacity = '0';
                setTimeout(() => {
                    contentSections.forEach(section => section.classList.add('hidden'));
                    const activeSection = document.getElementById(targetId + '-content');
                    if (activeSection) activeSection.classList.remove('hidden');
                    navLinks.forEach(link => {
                        link.classList.remove('active');
                        if (link.getAttribute('href') === '#' + targetId) link.classList.add('active');
                    });
                    contentArea.style.opacity = '1';
                }, 150);
            }

            navLinks.forEach(link => {
                if (!link.closest('form')) {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        const targetId = link.getAttribute('href').substring(1);
                        if (window.location.hash !== '#' + targetId) { window.location.hash = targetId; } else { showContent(targetId); }
                        if (window.innerWidth < 768) { sidebar.classList.add('-translate-x-full'); }
                    });
                }
            });

            function handleHashChange() {
                const hash = window.location.hash.substring(1) || 'dashboard';
                showContent(hash);
            }
            
            contentArea.style.transition = 'opacity 0.15s ease-in-out';
            handleHashChange();
            window.addEventListener('hashchange', handleHashChange);
            
            // --- Dark Mode Toggle Logic ---
            const themeToggleBtn = document.getElementById('theme-toggle');
            const darkIcon = document.getElementById('theme-toggle-dark-icon');
            const lightIcon = document.getElementById('theme-toggle-light-icon');

            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                lightIcon.classList.remove('hidden');
            } else {
                darkIcon.classList.remove('hidden');
            }

            themeToggleBtn.addEventListener('click', function() {
                darkIcon.classList.toggle('hidden');
                lightIcon.classList.toggle('hidden');

                if (localStorage.getItem('color-theme')) {
                    if (localStorage.getItem('color-theme') === 'light') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    }
                } else {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    }
                }
            });
        });
    </script>
</body>
</html>