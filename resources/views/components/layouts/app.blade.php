<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Kos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fade-in 0.4s ease-out;
        }
    </style>

    @livewireStyles
</head>
<body class="bg-gradient-to-tr from-blue-500 via-white to-blue-500 text-gray-800 min-h-screen">

    <div class="min-h-screen flex flex-col">

       <nav class="bg-blue-700 shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="text-xl font-bold text-white flex items-center space-x-2">
            <span>🏠</span>
            <span>Sistem Kos</span>
        </div>
        <div class="space-x-6 text-sm font-medium">
            <a href="{{ route('kamar') }}" class="text-white hover:text-blue-200 transition-all duration-200">Kamar</a>
            <a href="{{ route('booking') }}" class="text-white hover:text-blue-200 transition-all duration-200">Booking</a>
            <a href="{{ route('pembayaran') }}" class="text-white hover:text-blue-200 transition-all duration-200">Pembayaran</a>
        </div>
    </div>
</nav>

        <!-- Konten -->
        <main class="flex-grow animate-fade-in">
            <div class="max-w-7xl mx-auto px-6 py-8">
                {{ $slot ?? '' }}
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-blue-700 text-white py-4 text-center text-sm shadow-inner">
            &copy; {{ date('Y') }} <strong>Sistem Kos</strong> | Dibuat dengan 💙 oleh <span class="font-semibold">Kevien Nathallio Antonio</span>
        </footer>
    </div>

    @livewireScripts
</body>
</html>
