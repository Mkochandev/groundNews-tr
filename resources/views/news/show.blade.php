<!DOCTYPE html>
<html lang="tr" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $newsCluster->title }} - Ground News TR</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: { bg: '#1a1a1a', card: '#242424', hover: '#2d2d2d' },
                        bias: { left: '#E34848', center: '#9CA3AF', right: '#3B82F6' }
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #1a1a1a;
            color: #E0E0E0;
        }

        .tab-button.active {
            background-color: #2d2d2d;
            border-bottom: 2px solid #3B82F6;
        }
    </style>
</head>

<body>

    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex gap-6">

            <!-- Main Content -->
            <main class="flex-1">

                <!-- Title -->
                <h1 class="text-4xl font-bold text-white mb-6 leading-tight">{{ $newsCluster->title }}</h1>

                <!-- Image Section (Below Title) -->
                @if($newsCluster->image_url)
                    <div class="mb-8 w-full max-w-4xl mx-auto">
                        <div class="relative w-full" style="aspect-ratio: 16/9;">
                            <img src="{{ $newsCluster->image_url }}" alt="{{ $newsCluster->title }}"
                                class="absolute inset-0 w-full h-full object-cover rounded-lg shadow-xl" loading="eager">
                        </div>
                    </div>
                @endif

                <div class="text-sm text-gray-500 mb-6">
                    Yayınlanma {{ $newsCluster->created_at->diffForHumans() }} • Güncellenme
                    {{ $newsCluster->updated_at->diffForHumans() }}
                </div>

                @php
                    $bias = is_array($newsCluster->bias_data) ? $newsCluster->bias_data : json_decode($newsCluster->bias_data, true);
                @endphp

                <!-- Bias Bar -->
                <div class="mb-8">
                    <h2 class="text-xl font-bold text-white mb-3">Siyasi Spektrum Dağılımı</h2>
                    <div class="flex gap-px h-4 rounded overflow-hidden mb-2">
                        @if(isset($bias['left']) && $bias['left'] > 0)
                            <div class="bg-bias-left flex items-center justify-center" style="width: {{ $bias['left'] }}%;">
                                <span class="text-xs text-white font-bold">{{ $bias['left'] }}%</span>
                            </div>
                        @endif
                        @if(isset($bias['center']) && $bias['center'] > 0)
                            <div class="bg-bias-center flex items-center justify-center"
                                style="width: {{ $bias['center'] }}%;">
                                <span class="text-xs text-white font-bold">{{ $bias['center'] }}%</span>
                            </div>
                        @endif
                        @if(isset($bias['right']) && $bias['right'] > 0)
                            <div class="bg-bias-right flex items-center justify-center"
                                style="width: {{ $bias['right'] }}%;">
                                <span class="text-xs text-white font-bold">{{ $bias['right'] }}%</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex justify-between text-xs text-gray-400">
                        <span>Sol {{ $bias['left'] ?? 0 }}%</span>
                        <span>Merkez {{ $bias['center'] ?? 0 }}%</span>
                        <span>Sağ {{ $bias['right'] ?? 0 }}%</span>
                    </div>
                </div>

                <!-- 3-Column Perspective Analysis -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-white mb-6">Perspektif Analizi</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Left Perspective -->
                        <div class="bg-dark-card rounded-lg overflow-hidden border-t-4 border-bias-left">
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-bias-left mb-4 flex items-center gap-2">
                                    <span>◀</span> Sol Bakış
                                </h3>
                                <p class="text-gray-300 leading-relaxed">
                                    {{ $newsCluster->summary_left ?? 'Veri yok' }}
                                </p>
                            </div>
                        </div>

                        <!-- Center Perspective -->
                        <div class="bg-dark-card rounded-lg overflow-hidden border-t-4 border-bias-center">
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-bias-center mb-4 flex items-center gap-2">
                                    <span>■</span> Merkez Bakış
                                </h3>
                                <p class="text-gray-300 leading-relaxed">
                                    {{ $newsCluster->summary_center ?? 'Veri yok' }}
                                </p>
                            </div>
                        </div>

                        <!-- Right Perspective -->
                        <div class="bg-dark-card rounded-lg overflow-hidden border-t-4 border-bias-right">
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-bias-right mb-4 flex items-center gap-2">
                                    <span>▶</span> Sağ Bakış
                                </h3>
                                <p class="text-gray-300 leading-relaxed">
                                    {{ $newsCluster->summary_right ?? 'Veri yok' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- General Summary -->
                <div class="bg-dark-card rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-bold text-white mb-4">Genel Özet</h2>
                    <p class="text-gray-300 leading-relaxed text-lg">
                        {{ $newsCluster->summary ?? 'Özet henüz oluşturulmadı' }}
                    </p>
                </div>

                <!-- Sources Section -->
                <div class="mt-8">
                    <h3 class="text-xl font-bold text-white mb-4">Kaynak Dağılımı</h3>

                    @php
                        $bias = is_array($newsCluster->bias_data) ? $newsCluster->bias_data : json_decode($newsCluster->bias_data, true);
                        $leftCount = round(($bias['left'] ?? 0) * $newsCluster->source_count / 100);
                        $centerCount = round(($bias['center'] ?? 0) * $newsCluster->source_count / 100);
                        $rightCount = round(($bias['right'] ?? 0) * $newsCluster->source_count / 100);
                    @endphp

                    <!-- Bias Distribution Bar -->
                    <div class="flex gap-px h-3 mb-6 rounded overflow-hidden">
                        @if(isset($bias['left']) && $bias['left'] > 0)
                            <div class="bg-bias-left flex items-center justify-center text-xs text-white"
                                style="width: {{ $bias['left'] }}%;">
                                <span class="font-semibold">{{ $bias['left'] }}%</span>
                            </div>
                        @endif
                        @if(isset($bias['center']) && $bias['center'] > 0)
                            <div class="bg-bias-center flex items-center justify-center text-xs text-white"
                                style="width: {{ $bias['center'] }}%;">
                                <span class="font-semibold">{{ $bias['center'] }}%</span>
                            </div>
                        @endif
                        @if(isset($bias['right']) && $bias['right'] > 0)
                            <div class="bg-bias-right flex items-center justify-center text-xs text-white"
                                style="width: {{ $bias['right'] }}%;">
                                <span class="font-semibold">{{ $bias['right'] }}%</span>
                            </div>
                        @endif
                    </div>

                    @php
                        // Group articles by bias and unique sources
                        $articles = $newsCluster->articles->load('source');

                        $leftArticles = $articles->filter(fn($a) => optional($a->source)->base_bias < -2);
                        $centerArticles = $articles->filter(fn($a) => abs(optional($a->source)->base_bias) <= 2);
                        $rightArticles = $articles->filter(fn($a) => optional($a->source)->base_bias > 2);
                    @endphp

                    <!-- Source Icons Grid -->
                    <div class="grid grid-cols-3 gap-6">
                        <!-- Left Wing -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-400 mb-3 border-b border-gray-700 pb-2">
                                Sol Perspektifler ({{ $leftArticles->unique('source_id')->count() }})
                            </h4>
                            <div class="flex flex-col gap-3">
                                @forelse($leftArticles->unique('source_id') as $article)
                                    @php $domain = parse_url($article->url, PHP_URL_HOST); @endphp
                                    <a href="{{ $article->url }}" target="_blank"
                                        class="flex items-center group bg-dark-card p-3 rounded hover:bg-gray-800 transition">
                                        <img src="https://www.google.com/s2/favicons?domain={{ $domain }}&sz=48"
                                            class="w-8 h-8 rounded bg-white p-0.5 group-hover:ring-2 group-hover:ring-bias-left transition">
                                        <span class="ml-3 text-sm text-gray-300 group-hover:text-white truncate">
                                            {{ $article->source->name ?? $domain }}
                                        </span>
                                    </a>
                                @empty
                                    <span class="text-xs text-gray-600 italic">Bu görüşten henüz kaynak yok.</span>
                                @endforelse
                            </div>
                        </div>

                        <!-- Center -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-400 mb-3 border-b border-gray-700 pb-2">
                                Merkez Perspektifler ({{ $centerArticles->unique('source_id')->count() }})
                            </h4>
                            <div class="flex flex-col gap-3">
                                @forelse($centerArticles->unique('source_id') as $article)
                                    @php $domain = parse_url($article->url, PHP_URL_HOST); @endphp
                                    <a href="{{ $article->url }}" target="_blank"
                                        class="flex items-center group bg-dark-card p-3 rounded hover:bg-gray-800 transition">
                                        <img src="https://www.google.com/s2/favicons?domain={{ $domain }}&sz=48"
                                            class="w-8 h-8 rounded bg-white p-0.5 group-hover:ring-2 group-hover:ring-bias-center transition">
                                        <span class="ml-3 text-sm text-gray-300 group-hover:text-white truncate">
                                            {{ $article->source->name ?? $domain }}
                                        </span>
                                    </a>
                                @empty
                                    <span class="text-xs text-gray-600 italic">Bu görüşten henüz kaynak yok.</span>
                                @endforelse
                            </div>
                        </div>

                        <!-- Right Wing -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-400 mb-3 border-b border-gray-700 pb-2">
                                Sağ Perspektifler ({{ $rightArticles->unique('source_id')->count() }})
                            </h4>
                            <div class="flex flex-col gap-3">
                                @forelse($rightArticles->unique('source_id') as $article)
                                    @php $domain = parse_url($article->url, PHP_URL_HOST); @endphp
                                    <a href="{{ $article->url }}" target="_blank"
                                        class="flex items-center group bg-dark-card p-3 rounded hover:bg-gray-800 transition">
                                        <img src="https://www.google.com/s2/favicons?domain={{ $domain }}&sz=48"
                                            class="w-8 h-8 rounded bg-white p-0.5 group-hover:ring-2 group-hover:ring-bias-right transition">
                                        <span class="ml-3 text-sm text-gray-300 group-hover:text-white truncate">
                                            {{ $article->source->name ?? $domain }}
                                        </span>
                                    </a>
                                @empty
                                    <span class="text-xs text-gray-600 italic">Bu görüşten henüz kaynak yok.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Right Sidebar - Coverage Details -->
            <aside class="w-80 flex-shrink-0">
                <div class="sticky top-24 bg-dark-card rounded-lg p-6 border border-gray-800">
                    <h3 class="text-lg font-bold text-white mb-6">Kapsam Detayları</h3>

                    @php
                        // Calculate real distribution from database sources
                        $uniqueSources = $newsCluster->articles->load('source')->unique('source_id');

                        $leftCount = $uniqueSources->filter(fn($a) => optional($a->source)->base_bias < -2)->count();
                        $centerCount = $uniqueSources->filter(fn($a) => abs(optional($a->source)->base_bias) <= 2)->count();
                        $rightCount = $uniqueSources->filter(fn($a) => optional($a->source)->base_bias > 2)->count();

                        $total = $uniqueSources->count();
                        $maxCount = max($leftCount, $centerCount, $rightCount);
                        $maxLabel = $maxCount == $leftCount ? 'Left' : ($maxCount == $rightCount ? 'Right' : 'Center');
                        $maxBias = $total > 0 ? round(($maxCount / $total) * 100) : 0;
                    @endphp

                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Toplam Haber Kaynağı</span>
                            <span class="text-white font-bold text-xl">{{ $newsCluster->source_count }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Sola Eğilimli</span>
                            <span class="text-white font-bold">{{ $leftCount }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Sağa Eğilimli</span>
                            <span class="text-white font-bold">{{ $rightCount }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Merkez</span>
                            <span class="text-white font-bold">{{ $centerCount }}</span>
                        </div>

                        <hr class="border-gray-700">

                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Son Güncelleme</span>
                            <span class="text-white text-sm">{{ $newsCluster->updated_at->diffForHumans() }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Eğilim Dağılımı</span>
                            <span class="text-white font-bold">{{ $maxBias }}%
                                @if($maxLabel == 'Left') Sol
                                @elseif($maxLabel == 'Right') Sağ
                                @else Merkez
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- All Source Icons -->
                    <div class="mt-6 pt-6 border-t border-gray-700">
                        <h4 class="text-sm font-semibold text-gray-400 mb-4">Tüm Kaynaklar
                            ({{ $newsCluster->articles->unique('source_id')->count() }})</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($newsCluster->articles->unique('source_id') as $article)
                                @php $domain = parse_url($article->url, PHP_URL_HOST); @endphp
                                <a href="{{ $article->url }}" target="_blank"
                                    title="{{ $article->source->name ?? $domain }}">
                                    <img src="https://www.google.com/s2/favicons?domain={{ $domain }}&sz=32"
                                        class="w-10 h-10 rounded bg-white p-1 hover:opacity-70 transition">
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>

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
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Ana
                                Sayfa</a></li>
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
                        <li><a href="{{ route('about') }}"
                                class="text-gray-400 hover:text-white transition">Hakkımızda</a></li>
                        <li><a href="{{ route('methodology') }}"
                                class="text-gray-400 hover:text-white transition">Metodoloji</a></li>
                        <li><a href="{{ route('privacy') }}" class="text-gray-400 hover:text-white transition">Gizlilik
                                Politikası</a></li>
                        <li><a href="{{ route('contact') }}"
                                class="text-gray-400 hover:text-white transition">İletişim</a></li>
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


</body>

</html>