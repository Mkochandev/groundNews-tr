{{-- Bias Indicator Component --}}
@props([
    'leftPercent' => 0,
    'centerPercent' => 0,
    'rightPercent' => 0,
    'sourceCount' => 0,
    'showLabels' => true,
    'size' => 'default' // 'small', 'default', 'large'
])

@php
    $total = $leftPercent + $centerPercent + $rightPercent;
    // Normalize if total is not 100
    if ($total > 0 && $total != 100) {
        $leftPercent = round(($leftPercent / $total) * 100);
        $centerPercent = round(($centerPercent / $total) * 100);
        $rightPercent = 100 - $leftPercent - $centerPercent;
    }
    
    $barHeight = match($size) {
        'small' => 'h-1',
        'large' => 'h-3',
        default => 'h-1.5'
    };
    
    $textSize = match($size) {
        'small' => 'text-xs',
        'large' => 'text-sm',
        default => 'text-xs'
    };
@endphp

<div class="bias-indicator">
    @if($showLabels && $sourceCount > 0)
        <div class="flex items-center justify-between mb-2">
            <span class="{{ $textSize }} text-gray-600 font-medium">
                {{ $sourceCount }} Kaynak
            </span>
            <div class="flex items-center space-x-3 {{ $textSize }}">
                @if($leftPercent > 0)
                    <span class="flex items-center">
                        <span class="w-2 h-2 bg-left-bias rounded-full mr-1"></span>
                        <span class="font-semibold text-left-bias">%{{ $leftPercent }}</span>
                        <span class="text-gray-500 ml-0.5">Sol</span>
                    </span>
                @endif
                
                @if($centerPercent > 0)
                    <span class="flex items-center">
                        <span class="w-2 h-2 bg-center-bias rounded-full mr-1"></span>
                        <span class="font-semibold text-gray-600">%{{ $centerPercent }}</span>
                        <span class="text-gray-500 ml-0.5">Merkez</span>
                    </span>
                @endif
                
                @if($rightPercent > 0)
                    <span class="flex items-center">
                        <span class="w-2 h-2 bg-right-bias rounded-full mr-1"></span>
                        <span class="font-semibold text-right-bias">%{{ $rightPercent }}</span>
                        <span class="text-gray-500 ml-0.5">Sağ</span>
                    </span>
                @endif
            </div>
        </div>
    @endif
    
    <!-- Bias Bar -->
    <div class="bias-bar {{ $barHeight }} flex rounded-full overflow-hidden bg-gray-200">
        @if($leftPercent > 0)
            <div 
                class="bg-left-bias transition-all duration-300 hover:opacity-80" 
                style="width: {{ $leftPercent }}%"
                title="Sol: %{{ $leftPercent }}"
            ></div>
        @endif
        
        @if($centerPercent > 0)
            <div 
                class="bg-center-bias transition-all duration-300 hover:opacity-80" 
                style="width: {{ $centerPercent }}%"
                title="Merkez: %{{ $centerPercent }}"
            ></div>
        @endif
        
        @if($rightPercent > 0)
            <div 
                class="bg-right-bias transition-all duration-300 hover:opacity-80" 
                style="width: {{ $rightPercent }}%"
                title="Sağ: %{{ $rightPercent }}"
            ></div>
        @endif
    </div>
</div>
