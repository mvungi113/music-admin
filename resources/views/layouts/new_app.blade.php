<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <!-- Sidebar (Fixed on all screens) -->
    <aside 
        x-show="sidebarOpen || window.innerWidth >= 768"
        @keydown.window.escape="sidebarOpen = false"
        class="fixed inset-y-0 left-0 z-40 w-64 bg-[#020617] text-white flex flex-col py-8 px-6 min-h-screen transition-transform duration-200 transform md:translate-x-0"
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
        <nav class="flex-1">
            <ul class="space-y-6">
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 hover:text-indigo-400 {{ request()->routeIs('dashboard') ? 'text-indigo-400 font-semibold' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-grid" viewBox="0 0 16 16">
                            <path d="M2 2h4v4H2V2zm5 0h4v4H7V2zm-5 5h4v4H2V7zm5 0h4v4H7V7zm-5 5h4v4H2v-4zm5 0h4v4H7v-4z"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('usermanagement') }}" class="flex items-center space-x-3 hover:text-indigo-400 {{ request()->routeIs('usermanagement') ? 'text-indigo-400 font-semibold' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                            <path d="M13 7a2 2 0 1 0-4 0 2 2 0 0 0 4 0zm-2-3a3 3 0 1 1 0 6 3 3 0 0 1 0-6zm-6 3a2 2 0 1 0-4 0 2 2 0 0 0 4 0zm-2-3a3 3 0 1 1 0 6 3 3 0 0 1 0-6zm11 8c0-1-1-2-3-2s-3 1-3 2v1h6v-1zm-7 0c0-1-1-2-3-2s-3 1-3 2v1h6v-1z"/>
                        </svg>
                        <span>User Management</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('audio.submissions') }}" class="flex items-center space-x-3 hover:text-indigo-400 {{ request()->routeIs('audio.submissions') ? 'text-indigo-400 font-semibold' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-music-note-list" viewBox="0 0 16 16">
                            <path d="M12 13c0 1.105-1.12 2-2.5 2S7 14.105 7 13s1.12-2 2.5-2 2.5.895 2.5 2zm-2.5 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                            <path fill-rule="evenodd" d="M12 3v10h-1V3h1z"/>
                            <path d="M11 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                            <path d="M0 11.5A.5.5 0 0 1 .5 11h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-3A.5.5 0 0 1 .5 8h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-3A.5.5 0 0 1 .5 5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                        <span>Audio Submissions</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('offensive_content_review') }}" class="flex items-center space-x-3 hover:text-indigo-400 {{ request()->routeIs('offensive_content_review') ? 'text-indigo-400 font-semibold' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shield-exclamation" viewBox="0 0 16 16">
                            <path d="M8 0c-.69 0-1.342.132-1.972.378C3.12 1.07 1.5 2.522 1.5 4.5c0 6.356 5.5 10.5 6.5 10.5s6.5-4.144 6.5-10.5c0-1.978-1.62-3.43-4.528-4.122A7.01 7.01 0 0 0 8 0zm0 1c.638 0 1.25.122 1.82.35C13.09 2.02 14.5 3.29 14.5 4.5c0 5.822-4.5 9.5-6.5 9.5S1.5 10.322 1.5 4.5c0-1.21 1.41-2.48 4.68-3.15A6.99 6.99 0 0 1 8 1zm.93 4.412a.5.5 0 0 0-.858 0l-2.5 4.5A.5.5 0 0 0 6 10h4a.5.5 0 0 0 .428-.788l-2.5-4.5zM8 12a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                        </svg>
                        <span>Offensive Content Review</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reports') }}" class="flex items-center space-x-3 hover:text-indigo-400 {{ request()->routeIs('reports') ? 'text-indigo-400 font-semibold' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                            <path d="M0 0h1v15h15v1H0V0zm10 10h1v3h-1v-3zm-3-3h1v6H7V7zm-3 3h1v3H4v-3z"/>
                        </svg>
                        <span>Reports & Analytics</span>
                    </a>
                </li>
               
                        <li>
                            <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2 hover:text-indigo-400 {{ request()->routeIs('profile.edit') ? 'text-indigo-400 font-semibold' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm4-3a4 4 0 1 1-8 0 4 4 0 0 1 8 0z"/>
                                    <path fill-rule="evenodd" d="M8 9a5 5 0 0 0-5 5v.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V14a5 5 0 0 0-5-5z"/>
                                </svg>
                                <span>User Profile</span>
                            </a>
                        </li>
                    
            
            </ul>
        </nav>
        <div class="mt-10 border-t border-gray-700 pt-6">
            @auth
                <div class="font-medium text-base text-gray-100 mb-1">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400 mb-4">{{ Auth::user()->email }}</div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-2 py-2 rounded hover:bg-gray-800 transition">
                        {{ __('Log Out') }}
                    </button>
                </form>
            @endauth
        </div>
    </aside>

    <!-- Main Content -->
    <div class="md:ml-64 transition-all">
        @yield('content')
    </div>
</body>
</html>