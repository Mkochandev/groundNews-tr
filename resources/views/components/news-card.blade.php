{{-- News Card Component --}}
@props([
    'title' => '',
    'image' => null,
    'date' => now(),
    'leftPercent' => 0,
    'centerPercent' => 0,
    'rightPercent' => 0,
    'sourceCount' => 0,
    'variant' => 'default', // 'default', 'small', 'large', 'featured'
    'url' => '#',
    'excerpt' => null,
    'category' => null
])

@php
    $cardClasses = match($variant) {
        'small' => 'p-3',
        'large' => 'p-6',
        'featured' => 'p-8',
        default => 'p-4'
    };
    
    $titleClasses = match($variant) {
        'small' => 'text-sm font-semibold',
        'large' => 'text-2xl font-bold',
        'featured' => 'text-3xl font-bold',
        default => 'text-lg font-bold'
    };
    
    $hasImage = $image !== null && $variant !== 'small';
@endphp

<article class="news-card bg-white rounded-lg shadow-md overflow-hidden {{ $cardClasses }} hover:shadow-xl fade-in group">
    <a href="{{ $url }}" class="block">
        @if($variant === 'featured' && $hasImage)
            <!-- Featured Layout with Large Image -->
            <div class="relative h-96 -mx-8 -mt-8 mb-6 overflow-hidden">
                <img 
                    src="{{ $image }}" 
                    alt="{{ $title }}"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                    @if($category)
                        <span class="inline-block px-3 py-1 bg-purple-600 rounded-full text-sm font-medium mb-3">
                            {{ $category }}
                        </span>
                    @endif
                    <h2 class="{{ $titleClasses }} text-white mb-3 line-clamp-3">{{ $title }}</h2>
                    @if($excerpt)
                        <p class="text-gray-200 text-base mb-4 line-clamp-2">{{ $excerpt }}</p>
                    @endif
                </div>
            </div>
        @elseif($hasImage && $variant !== 'featured')
            <!-- Standard Layout with Side Image -->
            <div class="flex gap-4 mb-4">
                <div class="flex-1">
                    @if($category)
                        <span class="inline-block px-2 py-0.5 bg-purple-100 text-purple-700 rounded text-xs font-medium mb-2">
                            {{ $category }}
                        </span>
                    @endif
                    <h2 class="{{ $titleClasses }} text-gray-900 mb-2 line-clamp-3 group-hover:text-purple-600 transition">
                        {{ $title }}
                    </h2>
                    @if($excerpt && $variant === 'large')
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $excerpt }}</p>
                    @endif
                </div>
                <div class="w-32 h-24 flex-shrink-0 rounded-lg overflow-hidden">
                    <img 
                        src="{{ $image }}" 
                        alt="{{ $title }}"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                    >
                </div>
            </div>
        @else
            <!-- Text Only Layout -->
            <div class="mb-4">
                @if($category)
                    <span class="inline-block px-2 py-0.5 bg-purple-100 text-purple-700 rounded text-xs font-medium mb-2">
                        {{ $category }}
                    </span>
                @endif
                <h2 class="{{ $titleClasses }} text-gray-900 mb-2 line-clamp-3 group-hover:text-purple-600 transition">
                    {{ $title }}
                </h2>
                @if($excerpt && $variant === 'large')
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ $excerpt }}</p>
                @endif
            </div>
        @endif
        
        <!-- Metadata and Bias Indicator -->
        <div class="space-y-3">
            <div class="flex items-center justify-between text-xs text-gray-500">
                <span>{{ $date->diffForHumans() }}</span>
            </div>
            
            @if($sourceCount > 0)
                <x-bias-indicator 
                    :leftPercent="$leftPercent"
                    :centerPercent="$centerPercent"
                    :rightPercent="$rightPercent"
                    :sourceCount="$sourceCount"
                    :size="$variant === 'small' ? 'small' : 'default'"
                />
            @endif
        </div>
    </a>
</article>
