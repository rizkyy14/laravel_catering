<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin LUMINA • @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-stone-900 text-white">
            <div class="p-4 border-b border-stone-700">
                <span class="text-xl font-bold">LUMINA Admin</span>
            </div>
            <nav class="p-4">
                <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 rounded hover:bg-stone-800 mb-1">
                    <i class="fas fa-chart-line mr-2"></i> Dashboard
                </a>
                <a href="{{ route('admin.menu.index') }}" class="block py-2 px-4 rounded hover:bg-stone-800 mb-1">
                    <i class="fas fa-utensils mr-2"></i> Menu
                </a>
                <a href="{{ route('admin.event.index') }}" class="block py-2 px-4 rounded hover:bg-stone-800 mb-1">
                    <i class="fas fa-calendar mr-2"></i> Event
                </a>
                <a href="{{ route('admin.paket.index') }}" class="block py-2 px-4 rounded hover:bg-stone-800 mb-1">
                    <i class="fas fa-box mr-2"></i> Paket Catering
                </a>
                <a href="{{ route('admin.pemesanan') }}" class="block py-2 px-4 rounded hover:bg-stone-800 mb-1">
                    <i class="fas fa-shopping-cart mr-2"></i> Pemesanan
                </a>
                <hr class="my-4 border-stone-700">
                <a href="{{ route('home') }}" class="block py-2 px-4 rounded hover:bg-stone-800">
                    <i class="fas fa-home mr-2"></i> Lihat Website
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 px-4 rounded hover:bg-stone-800">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </button>
                </form>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <div class="bg-white shadow-sm p-4 flex justify-between items-center">
                <h2 class="text-xl font-semibold">@yield('title')</h2>
                <div class="text-sm text-stone-600">
                    {{ auth()->user()->nama }}
                </div>
            </div>
            <div class="p-6">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>