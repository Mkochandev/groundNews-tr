<header class="shadow-sm sticky top-0 z-50" style="background-color: #121212;">
    <!-- Top Bar -->
    <div class="text-white" style="background-color: #121212;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4 text-sm">
                    <span class="text-gray-400">Dengeli haber perspektifi</span>
                </div>
                <div class="flex items-center space-x-4">
                    <button
                        class="px-4 py-1.5 border border-gray-600 hover:border-gray-400 text-white text-sm font-medium rounded-full transition">
                        Giriş Yap
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="/" class="flex items-center">
                    @include('components.logo')
                </a>
            </div>

            <!-- Search Bar -->
            <div class="hidden md:flex flex-1 max-w-2xl mx-8">
                <div class="w-full relative">
                    <input type="text" placeholder="Haber ara veya konuya göz at..."
                        class="w-full px-4 py-2 pl-10 bg-gray-800 border border-gray-700 text-white placeholder-gray-400 rounded-full focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="hidden lg:flex items-center space-x-6">
                <a href="/" class="text-white hover:text-purple-400 font-medium transition">Ana Sayfa</a>
                <a href="/gundem" class="text-gray-400 hover:text-purple-400 font-medium transition">Gündem</a>
                <a href="/blindspot" class="text-gray-400 hover:text-purple-400 font-medium transition">Körnoktalar</a>
                <a href="/yerel" class="text-gray-400 hover:text-purple-400 font-medium transition">Yerel</a>
            </nav>

            <!-- Mobile Menu Button -->
            <button class="lg:hidden p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-800">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Trending Topics Bar -->
    <div class="border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center space-x-2 py-3 overflow-x-auto trending-scroll">
                <span class="text-sm font-semibold text-gray-700 whitespace-nowrap">Trendler:</span>

                <a href="#"
                    class="inline-flex items-center px-4 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-full text-sm font-medium whitespace-nowrap transition">
                    🔥 Ekonomi
                </a>
                <a href="#"
                    class="inline-flex items-center px-4 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-full text-sm font-medium whitespace-nowrap transition">
                    ⚡ Siyaset
                </a>
                <a href="#"
                    class="inline-flex items-center px-4 py-1.5 bg-green-100 text-green-700 hover:bg-green-200 rounded-full text-sm font-medium whitespace-nowrap transition">
                    🌍 Dünya
                </a>
                <a href="#"
                    class="inline-flex items-center px-4 py-1.5 bg-purple-100 text-purple-700 hover:bg-purple-200 rounded-full text-sm font-medium whitespace-nowrap transition">
                    ⚽ Spor
                </a>
                <a href="#"
                    class="inline-flex items-center px-4 py-1.5 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 rounded-full text-sm font-medium whitespace-nowrap transition">
                    💼 İş Dünyası
                </a>
                <a href="#"
                    class="inline-flex items-center px-4 py-1.5 bg-indigo-100 text-indigo-700 hover:bg-indigo-200 rounded-full text-sm font-medium whitespace-nowrap transition">
                    🔬 Bilim
                </a>
                <a href="#"
                    class="inline-flex items-center px-4 py-1.5 bg-pink-100 text-pink-700 hover:bg-pink-200 rounded-full text-sm font-medium whitespace-nowrap transition">
                    🎭 Kültür
                </a>
            </div>
        </div>
    </div>
</header>