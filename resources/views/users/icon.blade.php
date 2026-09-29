@props(['period'])

@php
$icons = [
    'sáng' => '
        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    ',

    'trưa' => '
        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a1 1 0 100-2 1 1 0 000 2z" />
        </svg>
    ',

    'chiều' => '
        <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 15a4 4 0 004 4h9a5 5 0 100-10 4 4 0 00-4-4H7a4 4 0 00-4 4z" />
        </svg>
    ',

    'tối' => '
        <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
    ',
];
@endphp

{!! $icons[$period] ?? '' !!}
