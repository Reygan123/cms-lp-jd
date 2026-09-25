<?php
if (! function_exists('formatRupiah')) {
    function formatRupiah($value)
    {
        return number_format($value, 0, ',', '.');
    }
}
