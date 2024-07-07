<?php

/**
 * @author saidqb
 * @@link http://saidqb.github.io
 *
 */

namespace Saidqb\Lib\Common;


trait Number
{
    static function phoneNumber($numHp, $removeLandingZero = false)
    {
        preg_match_all('!\d+!', $numHp, $matches);
        $numOnly = implode('', $matches[0]);
        $numOnly = str_replace(' ', '', $numOnly);
        $numOnly = (int)$numOnly;

        $phpFirst2 = substr($numOnly, 0, 2);

        if ($phpFirst2 == '62') {
            $numOnly = substr($numOnly, 2);
        }
        if ($removeLandingZero == true) {
            return (int)$numOnly;
        }
        return '0' . (int)$numOnly;
    }

    static function numberFormat($number, $typeCurrency = '', $lastNumber = 0)
    {
        if (!empty($number)) {

            $isNUmber = number_format($number, $lastNumber, ",", ".");

            if (!empty($typeCurrency)) {
                return $typeCurrency . ' ' . $isNUmber;
            }
            return $isNUmber;
        }
        return $typeCurrency . ' ' . $number;
    }


    static function getNumeric($str)
    {
        preg_match_all('/\d+/', $str, $matches);
        if (isset($matches[0][0])) {
            return $matches[0][0];
        }
        return '';
    }

    static function convertToRoman($integer)
    {
        // Convert the integer into an integer (just to make sure)
        $integer = intval($integer);
        $result = '';

        // Create a lookup array that contains all of the Roman numerals.
        $lookup = array(
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        );

        foreach ($lookup as $roman => $value) {
            // Determine the number of matches
            $matches = intval($integer / $value);

            // Add the same number of characters to the string
            $result .= str_repeat($roman, $matches);

            // Set the integer to be the remainder of the integer and the value
            $integer = $integer % $value;
        }

        // The Roman numeral should be built, return it
        return $result;
    }
}
