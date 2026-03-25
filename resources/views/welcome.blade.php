@extends('layouts.app')

@section('title', 'Ana Sayfa - Türkiye Haber Analizi')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Three Column Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- LEFT COLUMN - Daily Briefing & Top Stories -->
        <aside class="lg:col-span-3">
            <!-- Daily Briefing -->
            <div class="bg-gradient-to-br from-purple-600 to-indigo-700 rounded-lg p-6 text-white mb-6">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h2 class="text-xl font-bold">Günlük Özet</h2>
                </div>
                <p class="text-sm text-white/90 mb-4">
                    Bugünün en önemli 5 haberi, dengeli bir perspektifle sizin için özetlendi.
                </p>
                <button class="w-full bg-white text-purple-600 font-semibold py-2 px-4 rounded-lg hover:bg-gray-100 transition">
                    Özeti Görüntüle
                </button>
            </div>
            
            <!-- Top Stories List -->
            <div class="bg-white rounded-lg shadow-md p-5">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <span class="w-1 h-6 bg-purple-600 rounded mr-2"></span>
                    Günün Başlıkları
                </h3>
                <div class="space-y-4">
                    @foreach([
                        ['id' => 1, 'title' => 'Ekonomide yeni reform paketi açıklandı', 'sources' => 87, 'left' => 35, 'center' => 45, 'right' => 20],
                        ['id' => 2, 'title' => 'İstanbul\'da ulaşım projeleri hızlandı', 'sources' => 54, 'left' => 25, 'center' => 50, 'right' => 25],
                        ['id' => 3, 'title' => 'Eğitim sisteminde dijital dönüşüm', 'sources' => 42, 'left' => 30, 'center' => 40, 'right' => 30],
                        ['id' => 4, 'title' => 'Enerji sektöründe yeni yatırımlar', 'sources' => 65, 'left' => 20, 'center' => 35, 'right' => 45],
                        ['id' => 5, 'title' => 'Sağlık reformu detayları belli oldu', 'sources' => 71, 'left' => 40, 'center' => 40, 'right' => 20],
                    ] as $story)
                    <div class="border-b border-gray-100 last:border-0 pb-3 last:pb-0">
                        <a href="{{ route('news.detail', ['id' => $story['id'], 'slug' => Str::slug($story['title'])]) }}" class="block group">
                            <h4 class="text-sm font-semibold text-gray-900 mb-2 group-hover:text-purple-600 transition line-clamp-2">
                                {{ $story['title'] }}
                            </h4>
                            <x-bias-indicator 
                                :leftPercent="$story['left']"
                                :centerPercent="$story['center']"
                                :rightPercent="$story['right']"
                                :sourceCount="$story['sources']"
                                size="small"
                                :showLabels="false"
                            />
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </aside>
        
        <!-- MIDDLE COLUMN - Featured Story & Main Feed -->
        <main class="lg:col-span-6">
            <!-- Featured Story -->
            <div class="mb-8">
                <x-news-card 
                    variant="featured"
                    title="Türkiye'nin Enerji Politikası: Yenilenebilir Kaynaklar ve Geleceğe Yatırım"
                    excerpt="Enerji ve Tabii Kaynaklar Bakanlığı, önümüzdeki 10 yıl için yenilenebilir enerji yatırımlarıyla ilgili kapsamlı bir plan açıkladı. Uzmanlar, bu adımların enerji bağımsızlığı açısından kritik önemde olduğunu belirtiyor."
                    image="https://images.unsplash.com/photo-1509391366360-2e959784a276?w=1200&h=800&fit=crop"
                    :leftPercent="32"
                    :centerPercent="41"
                    :rightPercent="27"
                    :sourceCount="156"
                    category="Ekonomi"
                    :url="route('news.detail', ['id' => 100, 'slug' => 'turkiye-enerji-politikasi-yenilenebilir-kaynaklar'])"
                />
            </div>
            
            <!-- Main News Feed -->
            <div class="space-y-6">
                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                    <span class="w-1.5 h-8 bg-gradient-to-b from-purple-600 to-indigo-600 rounded mr-3"></span>
                    Son Haberler
                </h2>
                
                <x-news-card 
                    variant="large"
                    title="İstanbul'da Metro Hatları Genişletiliyor: 5 Yeni Hat Müjdesi"
                    excerpt="İstanbul Büyükşehir Belediyesi, şehrin ulaşım altyapısını güçlendirmek için 5 yeni metro hattı projesi açıkladı."
                    image="https://images.unsplash.com/photo-1581094271901-8022df4466f9?w=800&h=600&fit=crop"
                    :leftPercent="28"
                    :centerPercent="52"
                    :rightPercent="20"
                    :sourceCount="92"
                    category="Yerel"
                    :url="route('news.detail', ['id' => 101, 'slug' => 'istanbul-metro-hatlari-genisletiyor'])"
                />
                
                <x-news-card 
                    title="Türk Fintech Şirketleri Avrupa Pazarında İddialı"
                    image="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=600&fit=crop"
                    :leftPercent="22"
                    :centerPercent="48"
                    :rightPercent="30"
                    :sourceCount="67"
                    category="Teknoloji"
                    :url="route('news.detail', ['id' => 102, 'slug' => 'turk-fintech-sirketleri-avrupa-pazarinda'])"
                />
                
                <x-news-card 
                    title="Eğitimde Yapay Zeka Dönemi: Öğretmenler İçin Yeni Eğitimler"
                    image="https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=800&h=600&fit=crop"
                    :leftPercent="35"
                    :centerPercent="45"
                    :rightPercent="20"
                    :sourceCount="78"
                    category="Eğitim"
                    :url="route('news.detail', ['id' => 103, 'slug' => 'egitimde-yapay-zeka-donemi'])"
                />
                
                <x-news-card 
                    title="Türkiye ile AB Arasında Ticaret Görüşmeleri Devam Ediyor"
                    image="https://images.unsplash.com/photo-1526304640581-d334cdbbf45e?w=800&h=600&fit=crop"
                    :leftPercent="38"
                    :centerPercent="35"
                    :rightPercent="27"
                    :sourceCount="124"
                    category="Dış Politika"
                    :url="route('news.detail', ['id' => 104, 'slug' => 'turkiye-ab-ticaret-gorusmeleri'])"
                />
                
                <x-news-card 
                    title="Sağlık Turizmi Rekor Kırıyor: 2026 Hedefleri Açıklandı"
                    image="https://images.unsplash.com/photo-1538108149393-fbbd81895907?w=800&h=600&fit=crop"
                    :leftPercent="25"
                    :centerPercent="50"
                    :rightPercent="25"
                    :sourceCount="55"
                    category="Sağlık"
                    :url="route('news.detail', ['id' => 105, 'slug' => 'saglik-turizmi-rekor-kiriyor'])"
                />
            </div>
            
            <!-- Load More Button -->
            <div class="mt-8 text-center">
                <button class="px-8 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-semibold rounded-full transition transform hover:scale-105">
                    Daha Fazla Haber Yükle
                </button>
            </div>
        </main>
        
        <!-- RIGHT COLUMN - Blindspots & Categories -->
        <aside class="lg:col-span-3">
            <!-- Blindspots Section -->
            <div class="mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                    </svg>
                    Körnoktalar
                </h3>
                
                <div class="space-y-4">
                    <x-blindspot-card 
                        type="right"
                        title="Yenilenebilir Enerji Yatırımlarının Çevresel Etkileri"
                        category="Çevre"
                        :sourceCount="34"
                        :dominantPercent="72"
                    />
                    
                    <x-blindspot-card 
                        type="left"
                        title="Dijital Girişimcilerin Vergi Teşviklerinden Yararlanması"
                        category="Ekonomi"
                        :sourceCount="28"
                        :dominantPercent="68"
                    />
                </div>
            </div>
            
            <!-- Category Navigation -->
            <div class="bg-white rounded-lg shadow-md p-5">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Kategoriler</h3>
                <div class="space-y-2">
                    @foreach([
                        ['name' => 'Ekonomi', 'icon' => '📈', 'count' => 245],
                        ['name' => 'Siyaset', 'icon' => '🏛️', 'count' => 189],
                        ['name' => 'Dünya', 'icon' => '🌍', 'count' => 312],
                        ['name' => 'Teknoloji', 'icon' => '💻', 'count' => 156],
                        ['name' => 'Spor', 'icon' => '⚽', 'count' => 98],
                        ['name' => 'Sağlık', 'icon' => '🏥', 'count' => 87],
                        ['name' => 'Eğitim', 'icon' => '📚', 'count' => 65],
                        ['name' => 'Kültür-Sanat', 'icon' => '🎭', 'count' => 54],
                    ] as $category)
                    <a href="#" class="flex items-center justify-between p-3 rounded-lg hover:bg-purple-50 transition group">
                        <div class="flex items-center">
                            <span class="text-2xl mr-3">{{ $category['icon'] }}</span>
                            <span class="font-medium text-gray-700 group-hover:text-purple-600">{{ $category['name'] }}</span>
                        </div>
                        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">{{ $category['count'] }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
            
            <!-- Methodology Info -->
            <div class="mt-6 bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg p-5 border border-gray-200">
                <h4 class="font-bold text-gray-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Yanlılık Nasıl Hesaplanıyor?
                </h4>
                <p class="text-sm text-gray-600 mb-3">
                    Haberler analiz edilerek kaynak medyanın politik eğilimi değerlendirilir ve dengeli bir perspektif sunulur.
                </p>
                <a href="#" class="text-sm text-purple-600 hover:text-purple-700 font-medium">
                    Detaylı bilgi →
                </a>
            </div>
        </aside>
    </div>
</div>
@endsection
