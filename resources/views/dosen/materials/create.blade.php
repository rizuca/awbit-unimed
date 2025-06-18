<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Media Pembelajaran Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style> body { font-family: 'Inter', sans-serif; background-color: #f8fafc; } </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <div class="bg-white p-8 rounded-xl shadow-lg max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Form Tambah Media Baru</h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Oops!</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('dosen.materials.store') }}" method="POST" enctype="multipart/form-data" 
                  x-data="{ type: '{{ old('type', 'book') }}' }" class="space-y-6">
                @csrf
                
                {{-- Judul Materi --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Materi</label>
                    <input type="text" name="title" id="title" required class="mt-1 py-2 px-2 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('title') }}">
                </div>

                {{-- Dropdown Section --}}
                <div>
                    <label for="section_id" class="block text-sm font-medium text-gray-700">Pilih Section Pertemuan</label>
                    <select name="section_id" id="section_id" required class="mt-1 py-2 px-2 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">-- Pilih Section --</option>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}" {{ old('section_id') == $section->id ? 'selected' : '' }}>
                                {{ $section->course->name }} - {{ $section->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Deskripsi (Selalu Tampil) --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                    <textarea name="description" id="description" rows="3" class="py-2 px-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description') }}</textarea>
                </div>


                {{-- Tipe Materi --}}
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipe Materi</label>
                    <select name="type" id="type" x-model="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm py-2 px-2 ">
                        {{-- Opsi "Buku" diubah --}}
                        <option value="book">Buku (File PDF)</option>
                        <option value="video">Video (Link)</option>
                        <option value="ppt">File PPT</option>
                        <option value="file">File Lainnya</option>
                    </select>
                </div>

                {{-- Field Link Video (Hanya muncul jika tipe 'video') --}}
                <div x-show="type === 'video'">
                    <label for="content" class="block text-sm font-medium text-gray-700">Link Video (Embed URL)</label>
                    <textarea name="content" id="content" rows="4" class="py-2 px-2 mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: https://www.youtube.com/embed/XXXXXXX">{{ old('content') }}</textarea>
                </div>

                {{-- Field Upload File (Sekarang muncul untuk 'book', 'ppt', dan 'file') --}}
                <div x-show="type === 'book' || type === 'ppt' || type === 'file'">
                    <label for="file" class="block text-sm font-medium text-gray-700">Upload File</label>
                    <input type="file" name="file" id="file" class="mt-1 block w-full text-sm text-slate-500
                      file:mr-4 file:py-2 file:px-4
                      file:rounded-full file:border-0
                      file:text-sm file:font-semibold
                      file:bg-sky-50 file:text-sky-700
                      hover:file:bg-sky-100
                    ">
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-end gap-4 pt-4 border-t">
                    <a href="{{ route('dosen.materials.index') }}" class="py-2 px-4 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">Batal</a>
                    <button type="submit" class="py-2 px-4 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition-colors">Simpan Materi</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>