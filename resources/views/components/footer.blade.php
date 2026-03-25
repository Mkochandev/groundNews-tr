<!-- Footer -->
<footer class="bg-dark-card border-t border-gray-800 mt-16">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo & Description -->
            <div class="col-span-1 md:col-span-2">
                <div class="flex flex-col items-start mb-4">
                    <h1 class="text-white font-black text-2xl tracking-tighter" style="font-family: sans-serif;">
                        EKSEN
                    </h1>
                    <div class="w-32 h-1"
                        style="background: linear-gradient(to right, #E34848 0%, #D3D3D3 50%, #3B82F6 100%);"></div>
                </div>
                <p class="text-gray-400 text-sm mb-4 max-w-md">
                    Türkiye'nin ilk perspektif tabanlı haber platformu. Haberleri farklı siyasi görüşlerden okuyun,
                    medya balonundan çıkın, dengeli bilgi edinme hakkınızı kullanın.
                </p>
                <p class="text-gray-500 text-xs">
                    © 2026 Eksen. Tüm hakları saklıdır.
                </p>
            </div>

            <!-- Navigation Links -->
            <div>
                <h3 class="text-white font-bold mb-4">Keşfet</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Ana Sayfa</a>
                    </li>
                    <li><a href="{{ route('category.gundem') }}"
                            class="text-gray-400 hover:text-white transition">Gündem</a></li>
                    <li><a href="{{ route('category.siyaset') }}"
                            class="text-gray-400 hover:text-white transition">Siyaset</a></li>
                    <li><a href="{{ route('category.ekonomi') }}"
                            class="text-gray-400 hover:text-white transition">Ekonomi</a></li>
                </ul>
            </div>

            <!-- About Links -->
            <div>
                <h3 class="text-white font-bold mb-4">Eksen</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition">Hakkımızda</a>
                    </li>
                    <li><a href="{{ route('methodology') }}"
                            class="text-gray-400 hover:text-white transition">Metodoloji</a></li>
                    <li><a href="{{ route('privacy') }}" class="text-gray-400 hover:text-white transition">Gizlilik
                            Politikası</a></li>
                    <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition">İletişim</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="mt-8 pt-8 border-t border-gray-800">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-500">
                <p>
                    Eksen, yapay zeka destekli bir haber toplama ve analiz platformudur.
                    Tüm haberler otomatik olarak toplanır ve kategorize edilir.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-white transition">Twitter</a>
                    <a href="#" class="hover:text-white transition">LinkedIn</a>
                    <a href="#" class="hover:text-white transition">GitHub</a>
                </div>
            </div>
        </div>
    </div>
</footer>