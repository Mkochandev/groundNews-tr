<!DOCTYPE html>
<html lang="tr" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eksen | Yeni Nesil Haber Platformu</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            bg: '#1a1a1a',
                            card: '#242424',
                            hover: '#2d2d2d',
                        },
                        bias: {
                            left: '#E34848',
                            center: '#9CA3AF',
                            right: '#3B82F6',
                        }
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
    </style>
</head>

<body>

    @include('components.navbar')

    <div class="max-w-7xl mx-auto px-4 py-6">
        <div class="flex gap-6">

            <!-- Sol Sidebar -->
            <aside class="hidden lg:block w-72 flex-shrink-0">
                <h2 class="text-2xl font-bold text-white mb-4">Günün Özeti</h2>

                @if($sidebarBriefing->isNotEmpty())
                    <div class="space-y-4">
                        @foreach($sidebarBriefing as $briefing)
                            <a href="{{ route('news.show', $briefing->id) }}" class="block">
                                <div class="bg-dark-card rounded-lg overflow-hidden hover:bg-dark-hover transition">
                                    @if($briefing->image_url)
                                        <div class="relative w-full" style="aspect-ratio: 16/9;">
                                            <img src="{{ $briefing->image_url }}" alt="{{ $briefing->title }}"
                                                class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                                        </div>
                                    @else
                                        <div class="h-32 bg-gradient-to-br from-gray-700 to-gray-900"></div>
                                    @endif
                                    <div class="p-4">
                                        <div class="text-xs text-gray-500 mb-1">
                                            {{ $briefing->source_count }} haber &bull; {{ $briefing->articles->count() }} kaynak
                                        </div>
                                        <h3 class="font-bold text-white text-sm mb-2 line-clamp-3">{{ $briefing->title }}</h3>
                                        <p class="text-xs text-gray-400 line-clamp-2">{{ Str::limit($briefing->summary, 100) }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    @if($sidebarFeatured->isNotEmpty())
                        <h3 class="text-xl font-bold text-white mt-8 mb-4">Öne Çıkan Haberler</h3>
                        <div class="space-y-4">
                            @foreach($sidebarFeatured as $item)
                                <a href="{{ route('news.show', $item->id) }}" class="block">
                                    <div class="bg-dark-card rounded-lg overflow-hidden hover:bg-dark-hover transition">
                                        @if($item->image_url)
                                            <div class="relative w-full" style="aspect-ratio: 16/9;">
                                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                                                    class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                                            </div>
                                        @else
                                            <div class="h-32 bg-gradient-to-br from-gray-700 to-gray-900"></div>
                                        @endif
                                        <div class="p-4">
                                            <div class="text-xs text-gray-500 mb-1">
                                                {{ $item->source_count }} haber &bull; {{ $item->articles->count() }} kaynak
                                            </div>
                                            <h3 class="font-bold text-white text-sm mb-2 line-clamp-3">{{ $item->title }}</h3>
                                            <p class="text-xs text-gray-400 line-clamp-2">{{ Str::limit($item->summary, 100) }}</p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                @endif
            </aside>

            <!-- Ana İçerik -->
            <main class="flex-1">
                @if($newsClusters->isEmpty())
                    <div class="bg-dark-card rounded-lg p-12 text-center">
                        <h3 class="text-2xl font-bold text-white mb-2">Henüz Analiz Edilmiş Haber Yok</h3>
                        <p class="text-gray-400">Haber kümelerini analiz etmek için komutu çalıştırın</p>
                    </div>
                @else
                    <!-- Öne Çıkan Haber -->
                    @if($mainFeatured)
                        @php
                            $featuredBias = is_array($mainFeatured->bias_data)
                                ? $mainFeatured->bias_data
                                : json_decode($mainFeatured->bias_data, true);
                        @endphp

                        <article
                            class="bg-dark-card rounded-lg overflow-hidden mb-6 hover:bg-dark-hover transition cursor-pointer"
                            onclick="window.location='{{ route('news.show', $mainFeatured->id) }}'">
                            <div class="relative w-full" style="aspect-ratio: 16/9;">
                                @if($mainFeatured->image_url)
                                    <img src="{{ $mainFeatured->image_url }}" alt="{{ $mainFeatured->title }}"
                                        class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                                @else
                                    <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-gray-700 to-gray-900"></div>
                                @endif
                                <div class="absolute bottom-0 left-0 right-0 p-8 bg-gradient-to-t from-black/80">
                                    <h2 class="text-4xl font-bold text-white mb-4">{{ $mainFeatured->title }}</h2>

                                    <div class="flex gap-px h-2 mb-2">
                                        @if(($featuredBias['left'] ?? 0) > 0)
                                            <div class="bg-bias-left" style="width: {{ $featuredBias['left'] }}%;"></div>
                                        @endif
                                        @if(($featuredBias['center'] ?? 0) > 0)
                                            <div class="bg-bias-center" style="width: {{ $featuredBias['center'] }}%;"></div>
                                        @endif
                                        @if(($featuredBias['right'] ?? 0) > 0)
                                            <div class="bg-bias-right" style="width: {{ $featuredBias['right'] }}%;"></div>
                                        @endif
                                    </div>

                                    <div class="flex gap-4 text-xs text-gray-300">
                                        <span>Sol {{ $featuredBias['left'] ?? 0 }}%</span>
                                        <span>Merkez {{ $featuredBias['center'] ?? 0 }}%</span>
                                        <span>Sağ {{ $featuredBias['right'] ?? 0 }}%</span>
                                        <span class="ml-auto">{{ $mainFeatured->source_count }} kaynak</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endif

                    <!-- Haber Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($mainGrid as $story)
                            @php
                                $bias = is_array($story->bias_data)
                                    ? $story->bias_data
                                    : json_decode($story->bias_data, true);
                            @endphp

                            <article
                                class="bg-dark-card rounded-lg overflow-hidden hover:bg-dark-hover transition cursor-pointer flex gap-4"
                                onclick="window.location='{{ route('news.show', $story->id) }}'">
                                <div class="relative flex-shrink-0" style="width: 9rem; aspect-ratio: 1/1;">
                                    @if($story->image_url)
                                        <img src="{{ $story->image_url }}" alt="{{ $story->title }}"
                                            class="absolute inset-0 w-full h-full object-cover rounded-l-lg" loading="lazy">
                                    @else
                                        <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-gray-700 to-gray-800 rounded-l-lg"></div>
                                    @endif
                                </div>

                                <div class="flex-1 py-3 pr-3">
                                    <h3 class="font-bold text-white mb-3 leading-snug line-clamp-2">{{ $story->title }}</h3>

                                    <div class="flex gap-px h-1.5 mb-2 rounded-full overflow-hidden">
                                        @if(($bias['left'] ?? 0) > 0)
                                            <div class="bg-bias-left" style="width: {{ $bias['left'] }}%;"></div>
                                        @endif
                                        @if(($bias['center'] ?? 0) > 0)
                                            <div class="bg-bias-center" style="width: {{ $bias['center'] }}%;"></div>
                                        @endif
                                        @if(($bias['right'] ?? 0) > 0)
                                            <div class="bg-bias-right" style="width: {{ $bias['right'] }}%;"></div>
                                        @endif
                                    </div>

                                    <div class="flex gap-3 text-xs text-gray-500">
                                        <span>{{ $bias['left'] ?? 0 }}% Sol perspektif</span>
                                        <span>{{ $story->source_count }} kaynak</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </main>

            <!-- Sağ Sidebar - Gölge Gündem -->
            <aside class="hidden xl:block w-80 flex-shrink-0">
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex gap-1">
                        <div class="w-6 h-6 rounded-full bg-bias-left"></div>
                        <div class="w-6 h-6 rounded-full bg-bias-right -ml-2"></div>
                    </div>
                    <h3 class="text-2xl font-bold text-white">GÖLGE GÜNDEM</h3>
                </div>

                <p class="text-sm text-gray-400 mb-6">
                    Siyasi spektrumun bir tarafı tarafından orantısız şekilde kapsanan haberler.
                </p>

                <div class="space-y-4">
                    @forelse($blindspots as $blindspot)
                        @php
                            $bias = is_array($blindspot->bias_data)
                                ? $blindspot->bias_data
                                : json_decode($blindspot->bias_data, true);
                            $leftBias   = $bias['left'] ?? 0;
                            $centerBias = $bias['center'] ?? 0;
                            $rightBias  = $bias['right'] ?? 0;
                            $maxBias    = max($leftBias, $centerBias, $rightBias);

                            if ($maxBias === $leftBias) {
                                $dominantSide = 'Sol';
                                $shadowSide   = 'Sağın';
                                $borderColor  = 'border-blue-900/40';
                                $hoverColor   = 'hover:border-blue-800/60';
                                $badgeBg      = 'bg-blue-900/30';
                                $badgeText    = 'text-blue-400';
                            } elseif ($maxBias === $rightBias) {
                                $dominantSide = 'Sağ';
                                $shadowSide   = 'Solun';
                                $borderColor  = 'border-red-900/40';
                                $hoverColor   = 'hover:border-red-800/60';
                                $badgeBg      = 'bg-red-900/30';
                                $badgeText    = 'text-red-400';
                            } else {
                                $dominantSide = 'Merkez';
                                $shadowSide   = 'Uç Kesimlerin';
                                $borderColor  = 'border-gray-700/40';
                                $hoverColor   = 'hover:border-gray-600/60';
                                $badgeBg      = 'bg-gray-700/30';
                                $badgeText    = 'text-gray-400';
                            }
                        @endphp

                        <div class="border {{ $borderColor }} {{ $hoverColor }} rounded-lg overflow-hidden transition cursor-pointer"
                            onclick="window.location='{{ route('news.show', $blindspot->id) }}'">
                            @if($blindspot->image_url)
                                <div class="relative w-full" style="aspect-ratio: 16/9;">
                                    <img src="{{ $blindspot->image_url }}" alt="{{ $blindspot->title }}"
                                        class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                                </div>
                            @else
                                <div class="h-32 bg-gradient-to-br from-gray-700 to-gray-900"></div>
                            @endif
                            <div class="p-4 bg-dark-card">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-2 py-1 {{ $badgeBg }} {{ $badgeText }} text-xs rounded font-semibold">Gölge Gündem</span>
                                    <span class="text-xs text-gray-500">{{ $blindspot->source_count }} Kaynak</span>
                                </div>
                                <h4 class="font-semibold text-white text-sm mb-2 line-clamp-3">{{ $blindspot->title }}</h4>
                                <div class="text-xs {{ $badgeText }} font-medium">
                                    <span class="opacity-75">{{ $shadowSide }} Gölgesinde Kaldı</span>
                                    <span class="ml-1">({{ $maxBias }}% {{ $dominantSide }})</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-600">Şu an için belirgin bir gölge gündem haberi yok.</p>
                    @endforelse
                </div>
            </aside>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark-card border-t border-gray-800 mt-16">
        <div class="max-w-7xl mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex flex-col items-start mb-4">
                        <h1 class="text-white font-black text-2xl tracking-tighter" style="font-family: sans-serif;">EKSEN</h1>
                        <div class="w-32 h-1" style="background: linear-gradient(to right, #E34848 0%, #D3D3D3 50%, #3B82F6 100%);"></div>
                    </div>
                    <p class="text-gray-400 text-sm mb-4 max-w-md">
                        Türkiye'nin ilk perspektif tabanlı haber platformu. Haberleri farklı siyasi görüşlerden okuyun,
                        medya balonundan çıkın, dengeli bilgi edinme hakkınızı kullanın.
                    </p>
                    <p class="text-gray-500 text-xs">© 2026 Eksen. Tüm hakları saklıdır.</p>
                </div>

                <div>
                    <h3 class="text-white font-bold mb-4">Keşfet</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">Ana Sayfa</a></li>
                        <li><a href="{{ route('category.gundem') }}" class="text-gray-400 hover:text-white transition">Gündem</a></li>
                        <li><a href="{{ route('category.siyaset') }}" class="text-gray-400 hover:text-white transition">Siyaset</a></li>
                        <li><a href="{{ route('category.ekonomi') }}" class="text-gray-400 hover:text-white transition">Ekonomi</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-white font-bold mb-4">Eksen</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition">Hakkımızda</a></li>
                        <li><a href="{{ route('methodology') }}" class="text-gray-400 hover:text-white transition">Metodoloji</a></li>
                        <li><a href="{{ route('privacy') }}" class="text-gray-400 hover:text-white transition">Gizlilik Politikası</a></li>
                        <li><a href="{{ route('contact') }}" class="text-gray-400 hover:text-white transition">İletişim</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 pt-8 border-t border-gray-800">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-500">
                    <p>Eksen, yapay zeka destekli bir haber toplama ve analiz platformudur.</p>
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