<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enzzie Shop - Log In</title>

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
            backdrop-filter: blur(14px);
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

<div class="min-h-screen w-full bg-concert flex items-center justify-center px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <div class="content-layer glass-card
                w-full max-w-md sm:max-w-xl lg:max-w-3xl
                rounded-3xl
                shadow-2xl
                px-6 sm:px-12 lg:px-20
                py-10 sm:py-12 lg:py-16
                animate-fade-in">

        <!-- TITLE -->
        <h2 class="text-2xl sm:text-3xl lg:text-5xl font-black mb-3 text-center tracking-tight">
            Log In
        </h2>

        <p class="text-center text-gray-400 text-xs sm:text-sm mb-10 tracking-widest uppercase">
            Enzzie Shop Panel
        </p>

        <!-- ERROR -->
        @if ($errors->any())
            <div class="w-full mb-6
                        bg-red-500/10 border border-red-500/30
                        text-red-400 rounded-2xl px-4 py-3
                        text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <!-- Username -->
            <div class="mb-6">
                <label class="text-sm font-bold text-gray-200 mb-2 block uppercase tracking-widest">
                    Username
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       required
                       class="w-full bg-gray-950/70 border border-white/10
                              rounded-2xl py-4 px-6
                              text-base
                              focus:ring-4 focus:ring-blue-500
                              focus:bg-gray-900
                              outline-none transition-all duration-300">
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label class="text-sm font-bold text-gray-200 mb-2 block uppercase tracking-widest">
                    Password
                </label>

                <input type="password"
                       name="password"
                       required
                       class="w-full bg-gray-950/70 border border-white/10
                              rounded-2xl py-4 px-6
                              text-base
                              focus:ring-4 focus:ring-blue-500
                              focus:bg-gray-900
                              outline-none transition-all duration-300">
            </div>

            <!-- Remember -->
            <div class="flex items-center gap-3 mb-8">
                <input type="checkbox"
                       name="remember"
                       class="w-4 h-4 accent-blue-600">
                <label class="text-gray-400 text-sm">
                    Ingat saya
                </label>
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full bg-blue-700 hover:bg-blue-600
                           text-white py-4
                           rounded-full
                           text-lg font-black
                           transition duration-300
                           transform hover:scale-[1.02]
                           shadow-2xl uppercase tracking-widest">
                Masuk Sekarang
            </button>
        </form>

        <p class="text-sm text-gray-500 mt-10 text-center">
            Belum punya akun?
            <a href="{{ route('register') }}"
               class="text-white font-bold hover:underline">
                Register
            </a>
        </p>

    </div>
</div>

</body>
</html>