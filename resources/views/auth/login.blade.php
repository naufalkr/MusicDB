<x-guest-layout>
    <style>
        body {
            background-color: #121212; /* Warna latar belakang yang sama dengan welcome */
            color: #fff; /* Warna teks putih */
        }

        .login-container {
            max-width: 400px; /* Lebar maksimum kontainer */
            margin: auto; /* Tengah secara horizontal */
            padding: 20px; /* Padding di sekitar konten */
            background-color: #1e1e1e; /* Warna latar belakang kontainer */
            border-radius: 10px; /* Sudut yang halus */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5); /* Efek bayangan */
        }

        .login-title {
            font-size: 32px; /* Ukuran judul */
            font-weight: 600; /* Berat font */
            color: #1db954; /* Warna judul */
            margin-bottom: 20px; /* Jarak bawah judul */
            text-align: center; /* Tengah secara horizontal */
        }

        .btn-login {
            padding: 10px 0; /* Padding atas dan bawah */
            background-color: #1db954; /* Warna tombol */
            color: #fff; /* Warna teks tombol */
            border-radius: 25px; /* Sudut tombol yang halus */
            cursor: pointer; /* Cursor pointer */
            transition: background-color 0.3s ease; /* Transisi untuk efek hover */
            width: 100%; /* Lebar penuh */
        }

        .btn-login:hover {
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

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="login-container">
        <h1 class="login-title">Log In to MusicDB</h1>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button type="submit" class="btn-login">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>

        <div class="auth-links">
            <a href="/register">Register</a>
        </div>
    </div>
</x-guest-layout>
