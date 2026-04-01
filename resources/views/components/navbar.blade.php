<!-- Top Navbar -->
<nav class="bg-dark-card border-b border-gray-800 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Main Nav -->
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="flex flex-col items-start">
                    <h1 class="text-white font-black text-2xl tracking-tighter" style="font-family: sans-serif;">
                        EKSEN
                    </h1>
                    <div class="w-full h-1"
                        style="background: linear-gradient(to right, #E34848 0%, #D3D3D3 50%, #3B82F6 100%);"></div>
                </a>

                <div class="hidden md:flex items-center gap-6 text-sm">
                    <a href="{{ route('home') }}"
                        class="{{ !isset($category) ? 'text-white font-medium' : 'text-gray-400' }} hover:text-gray-300">Ana
                        Sayfa</a>
                    <a href="{{ route('category.senin-icin') }}"
                        class="{{ isset($category) && $category == 'senin-icin' ? 'text-white font-medium' : 'text-gray-400' }} hover:text-white">Senin
                        İçin</a>
                    <a href="{{ route('category.yerel') }}"
                        class="{{ isset($category) && $category == 'yerel' ? 'text-white font-medium' : 'text-gray-400' }} hover:text-white">Yerel</a>
                    <a href="{{ route('category.golge-gundem') }}"
                        class="{{ isset($category) && $category == 'golge-gundem' ? 'text-white font-medium' : 'text-gray-400' }} hover:text-white">Gölge
                        Gündem</a>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <input type="search" placeholder="Ara"
                    class="hidden md:block bg-dark-bg border border-gray-700 rounded px-4 py-2 text-sm text-white placeholder-gray-500 focus:outline-none focus:border-gray-600">
                <a href="{{ route('register') }}"
                    class="hidden md:block bg-white text-dark-bg px-6 py-2 rounded font-semibold text-sm hover:bg-gray-200">
                    Takip Et
                </a>
                <a href="{{ route('login') }}"
                    class="text-white border border-gray-700 px-6 py-2 rounded font-semibold text-sm hover:bg-dark-hover">
                    Giriş
                </a>
            </div>
        </div>

        <!-- Topic Tags -->
        <div class="nav-scrollbar flex gap-2 pb-3 text-sm">
            <a href="{{ route('home') }}"
                class="px-4 py-2 {{ !isset($category) ? 'bg-dark-hover text-white' : 'text-gray-400 hover:bg-dark-hover' }} rounded-full whitespace-nowrap">
                Tümü
            </a>
            <a href="{{ route('category.gundem') }}"
                class="px-4 py-2 {{ isset($category) && $category == 'gundem' ? 'bg-dark-hover text-white' : 'text-gray-400 hover:bg-dark-hover' }} rounded-full whitespace-nowrap">
                Gündem
            </a>
            <a href="{{ route('category.ekonomi') }}"
                class="px-4 py-2 {{ isset($category) && $category == 'ekonomi' ? 'bg-dark-hover text-white' : 'text-gray-400 hover:bg-dark-hover' }} rounded-full whitespace-nowrap">
                Ekonomi
            </a>
            <a href="{{ route('category.siyaset') }}"
                class="px-4 py-2 {{ isset($category) && $category == 'siyaset' ? 'bg-dark-hover text-white' : 'text-gray-400 hover:bg-dark-hover' }} rounded-full whitespace-nowrap">
                Siyaset
            </a>
            <a href="{{ route('category.dis-politika') }}"
                class="px-4 py-2 {{ isset($category) && $category == 'dis-politika' ? 'bg-dark-hover text-white' : 'text-gray-400 hover:bg-dark-hover' }} rounded-full whitespace-nowrap">
                Dış Politika
            </a>
            <a href="{{ route('category.yerel') }}"
                class="px-4 py-2 {{ isset($category) && $category == 'yerel' ? 'bg-dark-hover text-white' : 'text-gray-400 hover:bg-dark-hover' }} rounded-full whitespace-nowrap">
                Yerel
            </a>
            <a href="{{ route('category.teknoloji') }}"
                class="px-4 py-2 {{ isset($category) && $category == 'teknoloji' ? 'bg-dark-hover text-white' : 'text-gray-400 hover:bg-dark-hover' }} rounded-full whitespace-nowrap">
                Teknoloji
            </a>
            <a href="{{ route('category.spor') }}"
                class="px-4 py-2 {{ isset($category) && $category == 'spor' ? 'bg-dark-hover text-white' : 'text-gray-400 hover:bg-dark-hover' }} rounded-full whitespace-nowrap">
                Spor
            </a>
            <a href="{{ route('category.senin-icin') }}"
                class="px-4 py-2 {{ isset($category) && $category == 'senin-icin' ? 'bg-dark-hover text-white' : 'text-gray-400 hover:bg-dark-hover' }} rounded-full whitespace-nowrap">
                Senin İçin
            </a>
            <a href="{{ route('category.golge-gundem') }}"
                class="px-4 py-2 {{ isset($category) && $category == 'golge-gundem' ? 'bg-dark-hover text-white' : 'text-gray-400 hover:bg-dark-hover' }} rounded-full whitespace-nowrap">
                Gölge Gündem
            </a>
            <a href="{{ route('category.blindspot') }}"
                class="px-4 py-2 {{ isset($category) && $category == 'blindspot' ? 'bg-dark-hover text-white' : 'text-gray-400 hover:bg-dark-hover' }} rounded-full whitespace-nowrap">
                Körnoktalar
            </a>
        </div>
    </div>
</nav>

<style>
    .nav-scrollbar {
        overflow-x: auto;
        scrollbar-width: none;
    }

    .nav-scrollbar::-webkit-scrollbar {
        display: none;
    }
</style>