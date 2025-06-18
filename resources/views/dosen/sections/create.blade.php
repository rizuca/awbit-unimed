<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Section Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; background-color: #f8fafc; } </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <div class="bg-white p-8 rounded-xl shadow-lg max-w-2xl mx-auto">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Form Tambah Section Baru</h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('dosen.sections.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="course_id" class="block text-sm font-medium text-gray-700">Pilih Kelas</label>
                    <select name="course_id" id="course_id" required class="mt-1 py-2 px-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Section</label>
                    <input type="text" name="title" id="title" required class="mt-1 py-2 px-2 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: Pertemuan 1 - Pengenalan">
                </div>
                <div>
                    <label for="week_number" class="block text-sm font-medium text-gray-700">Minggu Ke-</label>
                    <input type="number" name="week_number" id="week_number" required class="mt-1 py-2 px-2 block w-full rounded-md border-gray-300 shadow-sm" placeholder="1">
                </div>
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                        <input type="date" name="start_date" id="start_date" required class="mt-1 py-2 px-2 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                        <input type="date" name="end_date" id="end_date" required class="mt-1 py-2 px-2 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 py-2 px-2 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                </div>

                <div class="flex justify-end gap-4 pt-4 border-t">
                    <a href="{{ route('dosen.dashboard') }}#section" class="py-2 px-4 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">Batal</a>
                    <button type="submit" class="py-2 px-4 bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition-colors">Simpan Section</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>