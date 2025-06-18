<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information, email address, and profile photo.") }}
        </p>
    </header>

    {{-- 
      PENTING: tambahkan enctype="multipart/form-data" agar form bisa mengirim file.
    --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="flex flex-col md:flex-row items-start gap-6">
            <div class="flex-shrink-0">
                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-2">
                    {{ __('Profile Photo') }}
                </h3>
                <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                    <input type="file" id="photo" name="photo" class="hidden"
                                x-ref="photo"
                                x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                                ">

                    <div class="mt-2" x-show="! photoPreview">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="rounded-full h-28 w-28 object-cover">
                    </div>

                    <div class="mt-2" x-show="photoPreview" style="display: none;">
                        <span class="block rounded-full w-28 h-28 bg-cover bg-no-repeat bg-center"
                              x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                        </span>
                    </div>

                    <button type="button" class="mt-4 text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500" x-on:click.prevent="$refs.photo.click()">
                        {{ __('Select A New Photo') }}
                    </button>
                </div>
            </div>

            <div class="flex-grow w-full">
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', Auth::user()->name)" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', Auth::user()->email)" required autocomplete="username" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
                        <div>
                            <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                {{ __('Your email address is unverified.') }}

                                <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>


        <div class="flex items-center gap-4 mt-6">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => { show = false; window.location.reload(); }, 1000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                    >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

{{-- Pastikan Anda memuat AlpineJS jika belum ada di layout utama Anda --}}
{{-- Biasanya sudah ada di app.js dari Breeze --}}
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>