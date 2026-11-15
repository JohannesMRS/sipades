@props(['title', 'text' => null, 'light' => false])
<div {{ $attributes->merge(['class' => 'max-w-2xl mb-8 md:mb-10']) }}>
  <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold {{ $light ? 'text-white' : 'text-deep' }}">{{ $title }}</h2>
  @if($text)<p class="mt-3 {{ $light ? 'text-white/80' : 'text-muted' }}">{{ $text }}</p>@endif
</div>
