<?php

namespace Saidqb\Lib\Support;

class Helper
{

    public static function issetVal($data, $key = '', $default = '')
    {
        if ($key === '') {
            $isset_data = isset($data) ? $data : $default;
            return static::emptyVal($data);
        }
        if (is_array($data)) {

            $isset_data =  isset($data[$key]) ? $data[$key] : $default;
            return static::emptyVal($isset_data, $default);
        } else {

            $isset_data =  isset($data->{$key}) ? $data->{$key} : $default;
            return static::emptyVal($isset_data, $default);
        }
    }

    public static function emptyVal($data, $default = '')
    {
        if ($data === 0 || $data === '0') {
            return $data;
        }

        return !empty($data) ? $data : $default;
    }

    public static function startWith($haystack, $needle)
    {
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }


    public static function endWith($haystack, $needle)
    {
        return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
    }

    public static function contains($haystack, $needle)
    {
        return strpos($haystack, $needle) !== FALSE;
    }


    public static function isJson($string)
    {
        return is_string($string) && is_array(json_decode($string, TRUE)) && (json_last_error() == JSON_ERROR_NONE) ? TRUE : FALSE;
    }

    // Check if array is associative
    public static function isAssoc($arr)
    {
        if (!is_array($arr)) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
