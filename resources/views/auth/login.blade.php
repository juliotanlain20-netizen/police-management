<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login | TRAKSA</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100">

    <div class="grid min-h-screen lg:grid-cols-2">

        {{-- LEFT PANEL --}}
        <section class="relative hidden overflow-hidden bg-[#0B1F3A] lg:flex">

            <div class="absolute inset-0">
                <div class="absolute -left-24 bottom-[-120px] h-80 w-80 rounded-full bg-blue-500/10"></div>
                <div class="absolute right-[-120px] top-[-80px] h-[420px] w-[420px] rounded-full bg-blue-400/10"></div>
                <div class="absolute left-1/3 top-1/4 h-72 w-72 rounded-full bg-sky-400/5"></div>
            </div>

            <div class="relative flex w-full flex-col justify-between px-16 py-16 text-white">
                <div>
                    <span class="text-sm font-bold uppercase tracking-[0.25em] text-blue-300">
                        Police Management System
                    </span>

                    <h1 class="mt-8 max-w-xl text-6xl font-extrabold leading-tight">
                        Pengelolaan Kasus Yang
                        <span class="text-blue-400">
                            Terstruktur Dan Terpercaya.
                        </span>
                    </h1>

                    <p class="mt-10 max-w-2xl text-2xl leading-relaxed text-slate-200">
                        Sistem manajemen pengaduan masyarakat, investigasi kasus,
                        dan barang bukti dalam satu platform terintegrasi.
                    </p>
                </div>

                <p class="text-base text-slate-400">
                    Sistem Manajemen Barang Bukti dan Pengaduan Masyarakat
                </p>
            </div>
        </section>

        {{-- RIGHT PANEL --}}
        <main class="flex items-center justify-center px-6 py-10 sm:px-8 lg:px-12">
            <div class="w-full max-w-[720px] rounded-none bg-[#F8FAFC] px-6 py-8 sm:px-10 sm:py-10 lg:bg-transparent lg:px-16 lg:py-0">

                {{-- LOGO --}}
                <div class="mb-8 flex justify-center">
                    <img
                        src="{{ asset('image/traksa-logo.png') }}"
                        alt="TRAKSA Logo"
                        class="h-28 w-auto sm:h-32"
                    >
                </div>

                {{-- HEADER --}}
                <div class="mb-8 text-center lg:text-left">
                    <span class="text-sm font-extrabold uppercase tracking-[0.2em] text-blue-500">
                        Welcome Back
                    </span>

                    <h2 class="mt-4 text-4xl font-extrabold tracking-tight text-slate-900 sm:text-5xl">
                        Masuk ke akun Anda
                    </h2>

                    <p class="mt-4 text-xl leading-relaxed text-slate-500">
                        Masukkan email dan password untuk melanjutkan.
                    </p>
                </div>

                {{-- SUCCESS --}}
                @if (session('success'))
                    <div class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-4 text-emerald-700">
                        <span class="mt-0.5 text-lg font-bold">✓</span>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                {{-- ERROR --}}
                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-4 text-rose-700">
                        <div class="mb-2 font-semibold">
                            Login tidak berhasil.
                        </div>

                        <ul class="list-disc space-y-1 pl-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- FORM --}}
                <form
                    action="{{ route('login.store') }}"
                    method="POST"
                    class="space-y-6"
                >
                    @csrf

                    {{-- EMAIL --}}
                    <div>
                        <label
                            for="email"
                            class="mb-3 block text-xl font-semibold text-slate-800"
                        >
                            Email
                        </label>

                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-5 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25H4.5a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5H4.5A2.25 2.25 0 0 0 2.25 6.75m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91A2.25 2.25 0 0 1 2.25 6.993V6.75" />
                                </svg>
                            </span>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                placeholder="nama@email.com"
                                autocomplete="email"
                                required
                                autofocus
                                class="w-full rounded-2xl border border-slate-300 bg-[#F8FAFC] py-4 pl-16 pr-5 text-xl text-slate-800 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
                            >
                        </div>
                    </div>

                    {{-- PASSWORD --}}
                    <div>
                        <label
                            for="password"
                            class="mb-3 block text-xl font-semibold text-slate-800"
                        >
                            Password
                        </label>

                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-5 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 0h10.5A2.25 2.25 0 0 1 19.5 12.75v6A2.25 2.25 0 0 1 17.25 21h-10.5A2.25 2.25 0 0 1 4.5 18.75v-6A2.25 2.25 0 0 1 6.75 10.5Z" />
                                </svg>
                            </span>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="Masukkan password"
                                autocomplete="current-password"
                                required
                                class="w-full rounded-2xl border border-slate-300 bg-[#F8FAFC] py-4 pl-16 pr-16 text-xl text-slate-800 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100"
                            >

                            <button
                                type="button"
                                data-password-toggle="password"
                                class="absolute inset-y-0 right-0 flex items-center pr-5 text-slate-500 hover:text-blue-600"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-6 w-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12S5.25 5.25 12 5.25 21.75 12 21.75 12 18.75 18.75 12 18.75 2.25 12 2.25 12Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15.75A3.75 3.75 0 1 0 12 8.25a3.75 3.75 0 0 0 0 7.5Z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- SUBMIT --}}
                    <button
                        type="submit"
                        class="w-full rounded-2xl bg-[#0B1F3A] px-6 py-4 text-xl font-bold text-white shadow-md transition hover:bg-[#12305a]"
                    >
                        Login
                    </button>
                </form>

                {{-- LINK BAWAH --}}
                <div class="mt-6 text-center">
                    <p class="text-base text-slate-500">
                        Belum punya akun?
                        <a
                            href="{{ route('register.form') }}"
                            class="font-semibold text-blue-600 hover:text-blue-700 hover:underline"
                        >
                            Buat akun dulu
                        </a>
                    </p>
                </div>

                {{-- SECURITY NOTE --}}
                <div class="mt-8 border-t border-slate-200 pt-6">
                    <div class="flex items-center justify-center gap-3 text-center text-sm text-slate-400 sm:text-base">
                        <span class="text-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m6 2.25c0 5.25-3.75 8.25-9 9-5.25-.75-9-3.75-9-9V6.75L12 3l9 3.75V12Z" />
                            </svg>
                        </span>

                        <span>
                            Akses sistem dilindungi dan hanya tersedia untuk pengguna yang terdaftar.
                        </span>
                    </div>
                </div>

            </div>
        </main>

    </div>

    <script>
        document
            .querySelectorAll('[data-password-toggle]')
            .forEach(function (button) {
                button.addEventListener('click', function () {
                    const input = document.getElementById(button.dataset.passwordToggle);
                    if (!input) return;
                    input.type = input.type === 'password' ? 'text' : 'password';
                });
            });
    </script>

</body>
</html>