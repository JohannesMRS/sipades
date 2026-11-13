@props(['title', 'text' => null, 'eyebrow' => null])
<div {{ $attributes->merge(['class' => 'max-w-2xl mb-10 reveal']) }}>
  @if($eyebrow)<span class="badge mb-3">{{ $eyebrow }}</span>@endif
  <h2 class="text-3xl md:text-4xl font-bold text-deep">{{ $title }}</h2>
  @if($text)<p class="mt-3 text-muted">{{ $text }}</p>@endif
</div>

