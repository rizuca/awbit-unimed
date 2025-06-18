<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Kelas Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; background-color: #f8fafc; } </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <div class="bg-white p-8 rounded-xl shadow-lg max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-slate-800">Form Pengajuan Kelas Baru</h1>
                <a href="{{ route('dosen.dashboard') }}" class="text-sm text-sky-600 hover:underline">&larr; Kembali ke Dashboard</a>
            </div>

            {{-- Menampilkan Error Validasi --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Oops! Ada kesalahan.</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('dosen.kelas.store') }}" method="POST" class="space-y-6">
                @csrf
                
                {{-- Field untuk Nama Kelas --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Kelas</label>
                    <input type="text" name="name" id="name" required class="mt-2 px-2 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" value="{{ old('name') }}" placeholder="Contoh: Pemrograman Web Lanjut">
                </div>

                {{-- Field untuk Kode Kelas --}}
                <div>
                    <label for="course_code" class="block text-sm font-medium text-gray-700">Kode Kelas</label>
                    <input type="text" name="course_code" id="course_code" required class="mt-2 px-2 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" value="{{ old('course_code') }}" placeholder="Contoh: PWL-01">
                </div>

                {{-- Field untuk Deskripsi --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Singkat (Opsional)</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 px-2 py-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500" placeholder="Jelaskan secara singkat tentang kelas ini">{{ old('description') }}</textarea>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-end gap-4 pt-4">
                    <a href="{{ route('dosen.dashboard') }}" class="py-2 px-4 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">Batal</a>
                    <button type="submit" class="py-2 px-4 bg-sky-600 text-white font-bold rounded-lg hover:bg-sky-700 transition-colors">Ajukan Kelas</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>