<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body x-data="{ sidebarOpen: false }" class="bg-gray-100 font-sans antialiased">

    <!-- Hamburger Button (Mobile Only) -->
    <button 
        @click="sidebarOpen = true"
        class="fixed top-4 left-4 z-40 md:hidden bg-[#020617] p-2 rounded focus:outline-none"
        x-show="!sidebarOpen"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <!-- Overlay (Mobile Only) -->
    <div 
        x-show="sidebarOpen"
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black bg-opacity-40 z-30 md:hidden"
        x-transition.opacity
    ></div>

    <!-- Sidebar -->
    <aside 
        x-show="sidebarOpen || window.innerWidth >= 768"
        @keydown.window.escape="sidebarOpen = false"
        class="fixed md:static inset-y-0 left-0 z-40 w-64 bg-[#020617] text-white flex flex-col py-8 px-6 min-h-screen transition-transform duration-200 transform md:translate-x-0"
        :class="{ '-translate-x-full': !sidebarOpen && window.innerWidth < 768, 'translate-x-0': sidebarOpen || window.innerWidth >= 768 }"
        x-transition
    >
        <div class="flex items-center justify-between mb-10">
            <span class="text-3xl font-bold tracking-wide">BASATA</span>
            <!-- Close Button (Mobile Only) -->
            <button class="md:hidden focus:outline-none" @click="sidebarOpen = false">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <!-- Sidebar content here -->
        <nav class="flex-1">
            <ul class="space-y-6">
                <!-- ...nav links... -->
            </ul>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="md:ml-64 transition-all">
        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>
