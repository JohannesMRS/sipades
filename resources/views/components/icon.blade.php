@props(['name'])
@php
$p = [
 'users' => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c0-3.6 2.9-6 6.5-6s6.5 2.4 6.5 6"/><path d="M16 5a3.5 3.5 0 010 6.5M18 14.3c2 .8 3.5 2.6 3.5 5.7"/>',
 'home'  => '<path d="M3 11l9-7.5 9 7.5"/><path d="M5.5 10v10h13V10"/><path d="M10 20v-5.5h4V20"/>',
 'map'   => '<path d="M12 21s7-6 7-11.5A7 7 0 005 9.5C5 15 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/>',
 'area'  => '<path d="M4 4h16v16H4z"/><path d="M4 9h5M4 14h3M9 4v5M14 4v3"/>',
 'chart' => '<path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/>',
 'coins' => '<ellipse cx="12" cy="6" rx="7" ry="3"/><path d="M5 6v6c0 1.7 3.1 3 7 3s7-1.3 7-3V6M5 12v6c0 1.7 3.1 3 7 3s7-1.3 7-3v-6"/>',
 'build' => '<path d="M4 21h16M6 21V8l6-4 6 4v13"/><path d="M10 21v-5h4v5M10 11h4"/>',
 'doc'   => '<path d="M6 3h8l4 4v14H6z"/><path d="M14 3v4h4M9 12h6M9 16h6"/>',
 'pin'   => '<path d="M12 21s7-6 7-11.5A7 7 0 005 9.5C5 15 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/>',
 'phone' => '<path d="M5 4h4l2 5-2.5 1.5a11 11 0 005 5L15 13l5 2v4a2 2 0 01-2 2A16 16 0 013 6a2 2 0 012-2z"/>',
 'mail'  => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
 'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
];
@endphp
<svg {{ $attributes->merge(['class' => 'size-6']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $p[$name] ?? '' !!}</svg>
