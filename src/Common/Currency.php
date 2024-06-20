<?php

/**
 * @author saidqb
 * @@link http://saidqb.github.io
 * 
 */

namespace Saidqb\Lib\Common;


trait Currency
{
    static function rupiah($value, $sep = 2, $prefix = '')
    {
        return $prefix . number_format($value, $sep, ',', '.');
    }

    static function dollar($value, $sep = 2, $prefix = '')
    {
        return $prefix . number_format($value, $sep, '.', ',');
    }

    static function rupiahToDecimal($value)
    {
        return str_replace(['.', ','], ['', '.'], $value);
    }

    static function decimalToRupiah($value, $sep = 2, $prefix = '')
    {
        return $prefix . number_format($value, $sep, ',', '.');
    }
}
