<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Media - {{ $material->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style> body { font-family: 'Inter', sans-serif; background-color: #f8fafc; } </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <div class="bg-white p-8 rounded-xl shadow-lg max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Form Edit Media</h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                </div>
            @endif

            <form action="{{ route('dosen.materials.update', $material->id) }}" method="POST" enctype="multipart/form-data" 
                  x-data="{ type: '{{ old('type', $material->type) }}' }" class="space-y-6">
                @csrf
                @method('PATCH') {{-- PENTING untuk update --}}
                
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Materi</label>
                    <input type="text" name="title" id="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="{{ old('title', $material->title) }}">
                </div>

                <div>
                    <label for="section_id" class="block text-sm font-medium text-gray-700">Pilih Section Pertemuan</label>
                    <select name="section_id" id="section_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}" {{ old('section_id', $material->section_id) == $section->id ? 'selected' : '' }}>
                                {{ $section->course->name }} - {{ $section->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                    <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $material->description) }}</textarea>
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Tipe Materi</label>
                    <select name="type" id="type" x-model="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="book">Buku (File PDF)</option>
                        <option value="video">Video (Link)</option>
                        <option value="ppt">File PPT</option>
                        <option value="file">File Lainnya</option>
                    </select>
                </div>

                <div x-show="type === 'video'">
                    <label for="content" class="block text-sm font-medium text-gray-700">Link Video (Embed URL)</label>
                    <textarea name="content" id="content" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('content', $material->content) }}</textarea>
                </div>

                <div x-show="type === 'book' || type === 'ppt' || type === 'file'">
                    <label for="file" class="block text-sm font-medium text-gray-700">Ganti File (Opsional)</label>
                    @if($material->file_path)
                    <p class="text-xs text-gray-500 mt-1">File saat ini: <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="text-blue-500 hover:underline">Lihat File</a></p>
                    @endif
                    <input type="file" name="file" id="file" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t">
                    <a href="{{ route('dosen.materials.index') }}" class="py-2 px-4 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Batal</a>
                    <button type="submit" class="py-2 px-4 bg-sky-600 text-white rounded-lg hover:bg-sky-700">Update Materi</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>