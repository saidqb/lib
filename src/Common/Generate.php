<?php 
/**
 * @author saidqb
 * @@link http://saidqb.github.io
 * 
 */
namespace Saidqb\Lib\Common;


trait Generate
{

	static function randomString($length,$type = 'A'){
		$typeArr = str_split($type);
		$token = "";
		$codeAlphabet = '';
		if(in_array('A',$typeArr)){
			$codeAlphabet.= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
		}
		if(in_array('C',$typeArr)){
			$codeAlphabet.= "+-_@#!$%^&";
			$codeAlphabet.= "+-_@#!$%^&";
		}
		if(in_array('N',$typeArr)){
			$codeAlphabet.= "0123456789";
			$codeAlphabet.= "0123456789";
		}
		$max = strlen($codeAlphabet);

		for ($i=0; $i < $length; $i++) {
			$token .= $codeAlphabet[random_int(0, $max-1)];
		}

		return $token;
	}
	
	static function randomANC($length){
		$token = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
		$codeAlphabet.= "+-_@#!$%^&";
		$codeAlphabet.= "0123456789";
		$codeAlphabet.= "+-_@#!$%^&";
		$max = strlen($codeAlphabet);

		for ($i=0; $i < $length; $i++) {
			$token .= $codeAlphabet[random_int(0, $max-1)];
		}

		return $token;
	}

	static function randomAN($length){
		$token = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
		$codeAlphabet.= "0123456789";
		$max = strlen($codeAlphabet);

		for ($i=0; $i < $length; $i++) {
			$token .= $codeAlphabet[random_int(0, $max-1)];
		}

		return $token;
	}

	static function randomA($length){
		$token = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
		$max = strlen($codeAlphabet);

		for ($i=0; $i < $length; $i++) {
			$token .= $codeAlphabet[random_int(0, $max-1)];
		}

		return $token;
	}

}