<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enzzie Shop - Global Merch Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .brand-font { font-family: 'Playfair Display', serif; }
        .bg-concert {
            background-image: linear-gradient(to bottom, rgba(0,0,0,0.5), rgba(0,0,0,0.8)), 
                              url("{{ asset('images/dekstop.png') }}");
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="min-h-screen bg-cover bg-center flex items-center justify-center"
      style="background-image: url('{{ asset('images/dekstop.jpg') }}');">

        <div class="flex flex-col items-center justify-between min-h-screen py-20">
    
    <!-- Brand Section -->
    <div class="text-center animate-fade-in">
        <h1 class="brand-font text-5xl md:text-7xl lg:text-8xl mb-2 tracking-tight text-white">
            Enzzie Shop
        </h1>
        <p class="italic text-gray-300 text-lg md:text-2xl font-light tracking-widest">
            Global Merch Store
        </p>
    </div>

    <!-- Button Section -->
    <div class="w-full max-w-md flex flex-col items-center gap-4">
        <a href="{{ route('login') }}"
   class="w-72 bg-blue-600 hover:bg-blue-500 text-white py-4 rounded-full font-bold text-lg shadow-lg transition duration-300 text-center">
   Login
</a>
        
        <p class="text-sm md:text-base text-gray-400">
            New to Enzzie Shop? 
            <a href="{{ route('register') }}" class="text-white font-bold hover:underline">
                Sign Up
            </a>
        </p>
    </div>

</div>

</body>
</html>