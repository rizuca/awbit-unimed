{{-- File: resources/views/partials/settings-modal.blade.php --}}

{{-- 
  Modal ini menggunakan AlpineJS untuk fungsionalitas buka/tutup dan tab.
  Pastikan AlpineJS sudah ter-load di proyek Anda.
--}}
<div 
    x-show="isSettingsModalOpen" 
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75"
    style="display: none;"
>
    <div 
        @click.away="isSettingsModalOpen = false" 
        x-show="isSettingsModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-3xl max-h-[90vh] flex flex-col"
    >
        {{-- Modal Header --}}
        <div class="flex items-center justify-between p-4 border-b dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Pengaturan Akun</h2>
            <button @click="isSettingsModalOpen = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                <i class="fas fa-times fa-lg"></i>
            </button>
        </div>

        {{-- Modal Body with Tabs --}}
        <div class="p-6 overflow-y-auto" x-data="{ tab: 'info' }">
            <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
                <nav class="-mb-px flex space-x-6">
                    <button @click="tab = 'info'" :class="{ 'border-sky-500 text-sky-600': tab === 'info', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'info' }" class="whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm">
                        Informasi Profil
                    </button>
                    <button @click="tab = 'password'" :class="{ 'border-sky-500 text-sky-600': tab === 'password', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'password' }" class="whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm">
                        Ubah Password
                    </button>
                    <button @click="tab = 'delete'" :class="{ 'border-red-500 text-red-600': tab === 'delete', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'delete' }" class="whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm">
                        Hapus Akun
                    </button>
                </nav>
            </div>

            {{-- Tab Content --}}
            <div>
                <div x-show="tab === 'info'" class="max-w-xl mx-auto">
                    @include('profile.partials.update-profile-information-form')
                </div>
                <div x-show="tab === 'password'" class="max-w-xl mx-auto">
                    @include('profile.partials.update-password-form')
                </div>
                <div x-show="tab === 'delete'" class="max-w-xl mx-auto">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>