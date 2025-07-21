<?php

if (!function_exists('formatPrice')) {
    function formatPrice($price)
    {
        if ($price >= 1000000000) {
            return 'Rp ' . number_format($price / 1000000000, 2, ',', '.') . ' Miliar';
        } elseif ($price >= 1000000) {
            return 'Rp ' . number_format($price / 1000000, 2, ',', '.') . ' Juta';
        } else {
            return 'Rp ' . number_format($price, 0, ',', '.');
        }
    }
}