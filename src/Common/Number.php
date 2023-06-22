<?php 
/**
 * @author saidqb
 * @@link http://saidqb.github.io
 * 
 */
namespace Saidqb\Filacms\Common;


trait Number
{


    static function phoneNumber($numHp, $removeLandingZero = false){
        preg_match_all('!\d+!', $numHp, $matches);
        $numOnly = implode('', $matches[0]);
        $numOnly = str_replace(' ','',$numOnly);
        $numOnly = (int)$numOnly;

        $phpFirst2 = substr($numOnly,0, 2);

        if($phpFirst2 == '62'){
            $numOnly = substr($numOnly, 2);
        }
        if($removeLandingZero == true){
            return (int)$numOnly;
        }
        return '0' . (int)$numOnly;
    }

    static function numberFormat($number, $typeCurrency = '', $lastNumber = 0){
        if(!empty($number)){

            $isNUmber = number_format($number,$lastNumber,",",".");

            if(!empty($typeCurrency)){
                return $typeCurrency . ' '. $isNUmber;
            }
            return $isNUmber;
        }
        return $typeCurrency .' '. $number;
    }


    static function getNumeric($str) {
        preg_match_all('/\d+/', $str, $matches);
        if(isset($matches[0][0])){
            return $matches[0][0];
        }
        return '';
    }
}

