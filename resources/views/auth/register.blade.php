<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enzzie Shop - Register</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Background blur */
        .bg-concert {
            position: relative;
            background: url("{{ asset('images/dekstop.jpg') }}");
            background-size: cover;
            background-position: center;
        }

        .bg-concert::before {
            content: "";
            position: absolute;
            inset: 0;
            backdrop-filter: blur(15px);
            background: rgba(0,0,0,0.65);
            z-index: 0;
        }

        .content-layer {
            position: relative;
            z-index: 10;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.07);
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
    </style>
</head>

<body class="text-white">

<div class="min-h-screen w-full bg-concert flex items-center justify-center px-4 sm:px-6 lg:px-8 py-10">

    <!-- GLASS CARD -->
    <div class="content-layer glass-card
                w-full max-w-md sm:max-w-2xl lg:max-w-4xl
                rounded-3xl
                shadow-2xl
                px-6 sm:px-12 lg:px-20
                py-10 sm:py-14 lg:py-16">

        <!-- TITLE -->
        <h2 class="text-3xl sm:text-4xl lg:text-6xl
                   font-black mb-10
                   text-center tracking-tight">
            Create Account
        </h2>

        <!-- ERROR -->
        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500/30
                        text-red-400 rounded-2xl px-4 py-3
                        mb-8 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('register.post') }}" method="POST"
              class="space-y-8 max-w-3xl mx-auto w-full">
            @csrf

            <!-- Username -->
            <div>
                <label class="text-sm font-bold text-gray-200 mb-2 block uppercase tracking-widest">
                    Username
                </label>
                <input type="text" name="name" required
                       class="w-full bg-gray-950/70 border border-white/10
                              rounded-2xl py-4 px-6
                              text-base
                              focus:ring-4 focus:ring-blue-500
                              focus:bg-gray-900
                              outline-none transition-all duration-300">
            </div>

            <!-- Email -->
            <div>
                <label class="text-sm font-bold text-gray-200 mb-2 block uppercase tracking-widest">
                    Email
                </label>
                <input type="email" name="email" required
                       class="w-full bg-gray-950/70 border border-white/10
                              rounded-2xl py-4 px-6
                              text-base
                              focus:ring-4 focus:ring-blue-500
                              focus:bg-gray-900
                              outline-none transition-all duration-300">
            </div>

            <!-- Password -->
            <div>
                <label class="text-sm font-bold text-gray-200 mb-2 block uppercase tracking-widest">
                    Password
                </label>
                <input type="password" name="password" required
                       class="w-full bg-gray-950/70 border border-white/10
                              rounded-2xl py-4 px-6
                              text-base
                              focus:ring-4 focus:ring-blue-500
                              focus:bg-gray-900
                              outline-none transition-all duration-300">
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="text-sm font-bold text-gray-200 mb-2 block uppercase tracking-widest">
                    Confirm Password
                </label>
                <input type="password" name="password_confirmation" required
                       class="w-full bg-gray-950/70 border border-white/10
                              rounded-2xl py-4 px-6
                              text-base
                              focus:ring-4 focus:ring-blue-500
                              focus:bg-gray-900
                              outline-none transition-all duration-300">
            </div>

            <!-- Button -->
            <button type="submit"
                    class="w-full bg-blue-700 hover:bg-blue-600
                           text-white py-4
                           rounded-full
                           text-lg font-black
                           transition duration-300
                           transform hover:scale-[1.02]
                           shadow-2xl uppercase tracking-widest">
                Daftar Sekarang
            </button>

        </form>

        <!-- Links -->
        <div class="text-center mt-10 space-y-3">
            <p class="text-gray-300 text-sm">
                Sudah punya akun?
                <a href="{{ route('login') }}"
                   class="text-white font-bold hover:underline">
                    Log In
                </a>
            </p>

            <p class="text-gray-400 text-xs">
                <a href="{{ route('welcome') }}"
                   class="hover:underline">
                    ← Kembali ke Beranda
                </a>
            </p>
        </div>

    </div>

</div>

</body>
</html>