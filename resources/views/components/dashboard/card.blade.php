@props([
  'title',
  'value' => 0,
  'icon' => 'cube',
  'badge' => null,
  'badgeColor' => 'bg-indigo-100 text-indigo-700',
  'subtitle' => null
])

<div class="bg-white border border-gray-200 rounded-xl p-5 flex flex-col gap-2 shadow-sm hover:shadow-md transition-all">

  <div class="flex items-center justify-between">
    <div>
      <p class="text-sm text-gray-600">{{ $title }}</p>
      <h3 class="text-2xl font-bold text-gray-900">{{ $value }}</h3>

      @if($subtitle)
        <p class="text-xs text-gray-500 mt-1">{{ $subtitle }}</p>
      @endif
    </div>

    {{-- ÍCONOS HEROICONS (igual que antes) --}}
    <div class="text-indigo-600">
      @switch($icon)
        @case('package')
          <x-heroicon-o-cube class="w-7 h-7" />
          @break
        @case('truck')
          <x-heroicon-o-truck class="w-7 h-7" />
          @break
        @case('store')
          <x-heroicon-o-building-storefront class="w-7 h-7" />
          @break
        @case('clipboard-list')
          <x-heroicon-o-clipboard-document-list class="w-7 h-7" />
          @break
        @case('clock')
          <x-heroicon-o-clock class="w-7 h-7" />
          @break
        @case('calendar')
          <x-heroicon-o-calendar-days class="w-7 h-7" />
          @break
        @default
          <x-heroicon-o-cog-6-tooth class="w-7 h-7" />
      @endswitch
    </div>
  </div>

  @if($badge)
    <span class="self-start text-xs mt-2 px-2 py-1 rounded {{ $badgeColor }}">
      {{ $badge }}
    </span>
  @endif

</div>
