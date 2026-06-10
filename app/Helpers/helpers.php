<?php

if (!function_exists('rupiah')) {
    function rupiah(?int $amount): string
    {
        if ($amount === null) return '-';
        return 'Rp ' . number_format($amount, 0, ',', '.') . ',-';
    }
}

if (!function_exists('rupiah_range')) {
    function rupiah_range(?int $min, ?int $max): string
    {
        if ($min === null && $max === null) return '-';
        if ($max === null) return 'Mulai ' . rupiah($min);
        return rupiah($min) . ' – ' . rupiah($max);
    }
}

if (!function_exists('wa_link')) {
    function wa_link(?string $number): ?string
    {
        if (!$number) return null;
        $clean = preg_replace('/[^0-9]/', '', $number);
        return 'https://wa.me/' . $clean;
    }
}

if (!function_exists('ig_link')) {
    function ig_link(?string $username): ?string
    {
        if (!$username) return null;
        $clean = ltrim($username, '@');
        return 'https://instagram.com/' . $clean;
    }
}
