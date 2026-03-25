{{-- Blindspot Card Component --}}
@props([
    'title' => '',
    'type' => 'left', // 'left' or 'right'
    'sourceCount' => 0,
    'dominantPercent' => 0,
    'url' => '#',
    'category' => null
])

@php
    $bgColor = $type === 'left' 
        ? 'bg-gradient-to-br from-red-600 to-red-700' 
        : 'bg-gradient-to-br from-orange-600 to-orange-700';
    
    $label = $type === 'left' 
        ? 'SOL KÖRNOKTASI' 
        : 'SAĞ KÖRNOKTASI';
        
    $description = $type === 'left'
        ? 'Sol eğilimli medya bu haberi daha az kapsıyor'
        : 'Sağ eğilimli medya bu haberi daha az kapsıyor';
@endphp

<article class="blindspot-card news-card {{ $bgColor }} rounded-lg shadow-lg overflow-hidden p-5 text-white fade-in group">
    <a href="{{ $url }}" class="block">
        <!-- Blindspot Label -->
        <div class="flex items-center justify-between mb-3">
            <span class="inline-flex items-center px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-xs font-bold uppercase tracking-wider">
                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                </svg>
                {{ $label }}
            </span>
            
            @if($category)
                <span class="text-xs font-medium opacity-90">{{ $category }}</span>
            @endif
        </div>
        
        <!-- Title -->
        <h3 class="text-xl font-bold mb-3 line-clamp-3 group-hover:opacity-90 transition">
            {{ $title }}
        </h3>
        
        <!-- Description -->
        <p class="text-sm text-white/80 mb-4">
            {{ $description }}
        </p>
        
        <!-- Stats -->
        <div class="flex items-center justify-between pt-3 border-t border-white/20">
            <div class="flex items-center space-x-4 text-sm">
                <span class="flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                    {{ $sourceCount }} Kaynak
                </span>
                
                <span class="flex items-center font-semibold">
                    %{{ $dominantPercent }} Kapsama
                </span>
            </div>
            
            <!-- Arrow Icon -->
            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
    </a>
</article>
