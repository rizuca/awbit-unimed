<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Media Pembelajaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style> body { font-family: 'Inter', sans-serif; background-color: #f8fafc; } </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <div class="bg-white p-8 rounded-xl shadow-lg">
            
            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Kelola Media Pembelajaran</h1>
                    <p class="text-sm text-slate-500">Daftar semua materi yang telah Anda tambahkan.</p>
                </div>
                <a href="{{ route('dosen.dashboard') }}" class="text-sm text-sky-600 hover:underline">
                    &larr; Kembali ke Dashboard
                </a>
            </div>

            {{-- Tombol Tambah --}}
            <div class="mb-6">
                <a href="{{ route('dosen.materials.create') }}" class="inline-block py-2 px-4 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Tambah Media Baru
                </a>
            </div>

            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Tabel Media Pembelajaran --}}
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="border-b bg-gray-50">
                        <tr>
                            <th class="py-3 px-4 text-sm font-semibold">No.</th>
                            <th class="py-3 px-4 text-sm font-semibold">Judul Materi</th>
                            <th class="py-3 px-4 text-sm font-semibold">Deskripsi</th>
                            <th class="py-3 px-4 text-sm font-semibold">Tipe</th>
                            <th class="py-3 px-4 text-sm font-semibold">Kelas</th>
                            <th class="py-3 px-4 text-sm font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($materials as $index => $material)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $index + 1 }}</td>
                            <td class="py-3 px-4 font-medium text-slate-800">{{ $material->title }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full capitalize
                                    @if($material->type == 'video') bg-red-100 text-red-800 @endif
                                    @if($material->type == 'book') bg-blue-100 text-blue-800 @endif
                                    @if($material->type == 'ppt') bg-orange-100 text-orange-800 @endif
                                    @if($material->type == 'file') bg-gray-100 text-gray-800 @endif
                                ">
                                    {{ $material->type }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-slate-600">{{ $material->section->course->name }}</td>
                            <td class="py-3 px-4 text-center">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('dosen.materials.edit', $material->id) }}" class="text-yellow-500 hover:text-yellow-700" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('dosen.materials.destroy', $material->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-slate-500">
                                Belum ada media pembelajaran yang ditambahkan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>