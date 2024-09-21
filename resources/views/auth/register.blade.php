<x-guest-layout>
    <style>
        body {
            background-color: #121212; /* Warna latar belakang yang sama dengan welcome */
            color: #fff; /* Warna teks putih */
        }

        .register-container {
            max-width: 400px; /* Lebar maksimum kontainer */
            margin: auto; /* Tengah secara horizontal */
            padding: 20px; /* Padding di sekitar konten */
            background-color: #1e1e1e; /* Warna latar belakang kontainer */
            border-radius: 10px; /* Sudut yang halus */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5); /* Efek bayangan */
        }

        .register-title {
            font-size: 32px; /* Ukuran judul */
            font-weight: 600; /* Berat font */
            color: #1db954; /* Warna judul */
            margin-bottom: 20px; /* Jarak bawah judul */
            text-align: center; /* Tengah secara horizontal */
        }

        .btn-register {
            padding: 10px 0; /* Padding atas dan bawah */
            background-color: #1db954; /* Warna tombol */
            color: #fff; /* Warna teks tombol */
            border-radius: 25px; /* Sudut tombol yang halus */
            cursor: pointer; /* Cursor pointer */
            transition: background-color 0.3s ease; /* Transisi untuk efek hover */
            width: 100%; /* Lebar penuh */
        }

        .btn-register:hover {
            background-color: #18a74a; /* Warna hover */
        }

        .auth-links {
            margin-top: 20px; /* Jarak atas untuk link autentikasi */
            text-align: center; /* Tengah secara horizontal */
        }

        .auth-links a {
            color: #b3b3b3; /* Warna link */
            text-decoration: none; /* Hilangkan garis bawah */
        }

        .auth-links a:hover {
            color: #fff; /* Warna hover link */
        }
    </style>

    <div class="register-container">
        <h1 class="register-title">Register to MusicDB</h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <button type="submit" class="btn-register">
                    {{ __('Register') }}
                </button>
            </div>
        </form>

        <div class="auth-links">
            <a href="/login">Log In</a>
        </div>
    </div>
</x-guest-layout>
