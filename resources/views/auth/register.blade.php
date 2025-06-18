{{-- File: resources/views/auth/register.blade.php --}}
{{-- Ganti seluruh isi file ini dengan kode di bawah --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Mahasiswa</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-5xl flex flex-col md:flex-row bg-white shadow-2xl rounded-2xl overflow-hidden">
        
        <div class="w-full md:w-1/2 p-8 md:p-12">
            <a href="{{ url('/') }}">
                <div class="flex items-center mb-6">
                    <svg class="w-8 h-8 text-blue-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.627 48.627 0 0 1 12 20.904a48.627 48.627 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" /></svg>
                    <h1 class="text-xl font-bold text-gray-700">Platform Akademik</h1>
                </div>
            </a>
            <h2 class="text-3xl font-bold text-gray-900">Buat Akun Mahasiswa</h2>
            <p class="mt-2 text-sm text-gray-500">Silakan isi data diri Anda untuk mendaftar.</p>
            
            <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                @csrf

                <!-- Nama Lengkap -->
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                    </div>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="block ps-12 p-3 w-full text-sm text-gray-900 bg-transparent rounded-lg border-2 @error('name') border-red-500 @else border-gray-300 @enderror appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="name" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-[3.25rem]">Nama Lengkap</label>
                    @error('name')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIM -->
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400"><path fill-rule="evenodd" d="M15.5 2A1.5 1.5 0 0014 3.5v13a1.5 1.5 0 001.5 1.5h.05a2 2 0 001.95-1.538l.001-.004.001-.003.001-.003A1.5 1.5 0 0015.5 15V3.5zM4.5 2A1.5 1.5 0 003 3.5v13a1.5 1.5 0 001.5 1.5h.05a2 2 0 001.95-1.538l.001-.004.001-.003.001-.003A1.5 1.5 0 004.5 15V3.5z" clip-rule="evenodd" /><path d="M8 3.5a1.5 1.5 0 011.5-1.5h1a1.5 1.5 0 011.5 1.5v13A1.5 1.5 0 0110.5 18h-1a1.5 1.5 0 01-1.5-1.5v-13z" /></svg>
                    </div>
                    <input type="text" id="nim_nidn" name="nim_nidn" value="{{ old('nim_nidn') }}" required autocomplete="username" class="block ps-12 p-3 w-full text-sm text-gray-900 bg-transparent rounded-lg border-2 @error('nim_nidn') border-red-500 @else border-gray-300 @enderror appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="nim_nidn" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-[3.25rem]">NIM (Nomor Induk Mahasiswa)</label>
                    @error('nim_nidn')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Email -->
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400"><path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" /><path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" /></svg>
                    </div>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="block ps-12 p-3 w-full text-sm text-gray-900 bg-transparent rounded-lg border-2 @error('email') border-red-500 @else border-gray-300 @enderror appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="email" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-[3.25rem]">Alamat Email</label>
                    @error('email')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kata Sandi -->
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" /></svg>
                    </div>
                    <input type="password" id="password" name="password" required autocomplete="new-password" class="block ps-12 p-3 w-full text-sm text-gray-900 bg-transparent rounded-lg border-2 @error('password') border-red-500 @else border-gray-300 @enderror appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="password" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-[3.25rem]">Kata Sandi</label>
                    @error('password')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Konfirmasi Kata Sandi -->
                 <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-gray-400"><path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" /></svg>
                    </div>
                    <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" class="block ps-12 p-3 w-full text-sm text-gray-900 bg-transparent rounded-lg border-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " />
                    <label for="password_confirmation" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-[3.25rem]">Konfirmasi Kata Sandi</label>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold text-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300 ease-in-out">
                    Daftar Sekarang
                </button>
            </form>
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-500">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">Masuk di sini</a>
                </p>
            </div>
        </div>
        
<div class="hidden md:flex md:w-1/2 items-center justify-center p-4">
            <div class="relative w-full h-full rounded-2xl overflow-hidden border-4 border-gray-200 shadow-lg">
                <video id="background-video" autoplay loop muted class="absolute top-0 left-0 w-full h-full object-cover">
                    <source id="video-source" src="" type="video/mp4">
                    Browser Anda tidak mendukung tag video.
                </video>
                
                <div class="absolute inset-0 bg-blue-600/50"></div>
                
                <div class="relative z-10 flex flex-col items-center justify-center h-full text-white p-10">
                     <h2 id="video-title" class="text-4xl font-bold text-center mb-4" style="text-shadow: 0 0 15px rgba(0, 0, 0, 0.5);"></h2>
                    <p id="video-subtitle" class="text-lg text-center max-w-sm" style="text-shadow: 0 0 10px rgba(0, 0, 0, 0.5);"></p>
                     <div class="absolute bottom-8 text-xs text-blue-200" style="text-shadow: 0 0 5px rgba(0, 0, 0, 0.5);">
                        &copy; 2025 Platform Akademik
                    </div>
                </div>
            </div>
        </div>
    </div>


        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const videos = [
                'videos/1.mp4',
                'videos/2.mp4',
                'videos/3.mp4',
                'videos/4.mp4',
                'videos/5.mp4',
                'videos/6.mp4',
                'videos/7.mp4'
            ];

            const captions = [
                { title: "Selamat Datang", subtitle: "Otak manusia bisa menyimpan informasi setara dengan lebih dari 1 juta gigabyte—lebih besar dari memori komputer manapun!" },
                { title: "Jelajahi Dunia Pengetahuan", subtitle: "Membaca selama 6 menit saja bisa mengurangi stres hingga 68%—lebih efektif daripada mendengarkan musik atau berjalan-jalan!" },
                { title: "Kolaborasi Tanpa Batas", subtitle: "Finlandia memiliki salah satu sistem pendidikan terbaik di dunia—dan muridnya tidak diberi PR berlebihan!" },
                { title: "Masa Depan di Tangan Anda", subtitle: "Air panas bisa membeku lebih cepat daripada air dingin dalam kondisi tertentu. Ini dikenal sebagai efek Mpemba!" },
                { title: "Inovasi dalam Pembelajaran", subtitle: "Menulis dengan tangan terbukti meningkatkan daya ingat lebih baik dibandingkan mengetik di keyboard." },
                { title: "Gerbang Menuju Kesuksesan", subtitle: "Waktu terbaik untuk belajar adalah pagi hari antara pukul 09.00–11.00 saat otak sedang aktif dan segar." },
                { title: "Satu Platform, Semua Kebutuhan", subtitle: "Belajar sambil menggambar atau membuat catatan visual (mind mapping) bisa meningkatkan pemahaman hingga 29% lebih baik." }
            ];
            const videoElement = document.getElementById('background-video');
            const sourceElement = document.getElementById('video-source');
            const titleElement = document.getElementById('video-title');
            const subtitleElement = document.getElementById('video-subtitle');
            let currentIndex = 0;

            function updateVideoAndCaption() {
                sourceElement.src = videos[currentIndex];
                const currentCaption = captions[currentIndex];
                titleElement.textContent = currentCaption.title;
                subtitleElement.textContent = currentCaption.subtitle;
                videoElement.load();
                currentIndex = (currentIndex + 1) % videos.length;
            }

            updateVideoAndCaption();
            setInterval(updateVideoAndCaption, 8000);
        });
    </script>

</body>
</html>
