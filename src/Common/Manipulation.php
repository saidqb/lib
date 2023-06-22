<?php 
/**
 * @author saidqb
 * @@link http://saidqb.github.io
 * 
 */
namespace Saidqb\Filacms\Common;


trait Manipulation
{
	
	static function excerpt($text, $chars = 25, $lastText = '...') {
		if (strlen($text) <= $chars) {
			return $text;
		}
		$text = $text." ";
		$text = substr($text,0,$chars);
		$text = substr($text,0,strrpos($text,' '));
		$text = $text.$lastText;
		return $text;
	}


	static function strToArray($str,$sparator = ',',$type = 'any'){
		$str = rawurldecode($str);
		$arr = explode($sparator, $str);
		$arr = array_filter($arr);

		$n = [];
		foreach ($arr as $key => $v) {
			$v = trim($v);
			if($type == 'num'){
				$v = Number::getNumeric($v);
				if(!is_numeric($v)){
					continue;
				}
			}
			$n[] = trim($v);
		}
		$n = array_filter($n);
		return $n;

	}

	/**
	 * [arrayMergeMultiChild merge array multi dimensial]
	 * @param  [type] $defaultArr [default data array]
	 * @param  array  $arr     [array dengan data sama atau kurang dengan default]
	 * @return [type]          [description]
	 */
	static function arrayMergeMultiChild($defaultArr,$arr = []){
		$new = [];
		if(is_object($arr)){
			$arr = (array)$arr;
		}
		if(is_object($defaultArr)){
			$defaultArr = (array)$defaultArr;
		}
		foreach ($defaultArr as $key => $value) {
			if(is_object($value)){
				$value = (array)$value;
			}


			$n = (isset($arr[$key]) ? $arr[$key] : $value);
			if(is_array($value)){
				$new[$key] =  self::arrayMergeMultiChild($value,$n);
				continue;
			}
			$new[$key] = $n;
		}
		return $new;
	}


	static function strToArrayGetNumber($str,$sparator = ','){
		return self::strToArray($str,$sparator = ',','num');
	}

	static function strRemove($str, $type = 'number|character'){

		$get_type = explode('|', $type);

		if(in_array('alpha',$get_type)){
			$str = preg_replace('/[^0-9_ -]/s',' ',$str);
		}

		if(in_array('character',$get_type)){
			$str = preg_replace('/[^a-zA-Z0-9_ -]/s',' ',$str);
		}

		if(in_array('number',$get_type)){
			$str = trim(preg_replace('/\d+/u', '', $str));
		}

		$str = trim($str);
		
		return $str;
	}

}