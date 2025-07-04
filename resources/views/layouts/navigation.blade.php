<!-- Sidebar Navigation -->
<aside x-data="{ open: true }" class="fixed md:static inset-y-0 left-0 z-30 w-64 bg-[#020617] text-white flex flex-col py-8 px-6 min-h-screen transition-transform duration-200 transform md:translate-x-0"
    :class="{ '-translate-x-full': !open, 'translate-x-0': open }">
    <div class="flex items-center justify-between mb-10">
        <div class="flex items-center space-x-3">
            <!-- Hamburger for mobile, always visible next to BASATA -->
            <button class="md:hidden focus:outline-none" @click="open = false">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <span class="text-3xl font-bold tracking-wide">BASATA</span>
        </div>
    </div>
    <nav class="flex-1">
        <ul class="space-y-6">
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 hover:text-indigo-400 {{ request()->routeIs('dashboard') ? 'text-indigo-400 font-semibold' : '' }}">
                    <!-- Hamburger for mobile, visible next to Dashboard -->
                    <button class="md:hidden focus:outline-none mr-2" @click.stop="open = false">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-grid" viewBox="0 0 16 16">
                        <path d="M2 2h4v4H2V2zm5 0h4v4H7V2zm-5 5h4v4H2V7zm5 0h4v4H7V7zm-5 5h4v4H2v-4zm5 0h4v4H7v-4z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-3 hover:text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                        <path d="M13 7a2 2 0 1 0-4 0 2 2 0 0 0 4 0zm-2-3a3 3 0 1 1 0 6 3 3 0 0 1 0-6zm-6 3a2 2 0 1 0-4 0 2 2 0 0 0 4 0zm-2-3a3 3 0 1 1 0 6 3 3 0 0 1 0-6zm11 8c0-1-1-2-3-2s-3 1-3 2v1h6v-1zm-7 0c0-1-1-2-3-2s-3 1-3 2v1h6v-1z"/>
                    </svg>
                    <span>User Management</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-3 hover:text-indigo-400">
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
                <a href="#" class="flex items-center space-x-3 hover:text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-shield-exclamation" viewBox="0 0 16 16">
                        <path d="M8 0c-.69 0-1.342.132-1.972.378C3.12 1.07 1.5 2.522 1.5 4.5c0 6.356 5.5 10.5 6.5 10.5s6.5-4.144 6.5-10.5c0-1.978-1.62-3.43-4.528-4.122A7.01 7.01 0 0 0 8 0zm0 1c.638 0 1.25.122 1.82.35C13.09 2.02 14.5 3.29 14.5 4.5c0 5.822-4.5 9.5-6.5 9.5S1.5 10.322 1.5 4.5c0-1.21 1.41-2.48 4.68-3.15A6.99 6.99 0 0 1 8 1zm.93 4.412a.5.5 0 0 0-.858 0l-2.5 4.5A.5.5 0 0 0 6 10h4a.5.5 0 0 0 .428-.788l-2.5-4.5zM8 12a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                    </svg>
                    <span>Offensive Content Review</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-3 hover:text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bar-chart-line" viewBox="0 0 16 16">
                        <path d="M0 0h1v15h15v1H0V0zm10 10h1v3h-1v-3zm-3-3h1v6H7V7zm-3 3h1v3H4v-3z"/>
                    </svg>
                    <span>Reports & Analytics</span>
                </a>
            </li>
            <li>
                <a href="#" class="flex items-center space-x-3 hover:text-indigo-400">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                        <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                        <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094a1.873 1.873 0 0 0 1.115-2.693l-.16-.291c-.415-.764.42-1.6 1.185-1.184l.291.159a1.873 1.873 0 0 0 2.693-1.116l.094-.318z"/>
                    </svg>
                    <span>Setting</span>
                </a>
            </li>
        </ul>
    </nav>
    <div class="mt-10 border-t border-gray-700 pt-6">
        <div class="font-medium text-base text-gray-100 mb-1">{{ Auth::user()->name }}</div>
        <div class="font-medium text-sm text-gray-400 mb-4">{{ Auth::user()->email }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left px-2 py-2 rounded hover:bg-gray-800 transition">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
    <!-- Mobile open button (show only on small screens) -->
    <button 
        x-data 
        x-show="!$store.sidebarOpen" 
        @click="$store.sidebarOpen = true" 
        class="fixed top-4 left-4 z-40 md:hidden bg-[#020617] p-2 rounded focus:outline-none"
        style="display: none;"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>
</aside>

<!-- Alpine.js for sidebar toggle (add this to your main layout if not already included) -->
<script src="//unpkg.com/alpinejs" defer></script>
