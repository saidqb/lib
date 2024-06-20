<?php

/**
 * @author saidqb
 * @@link http://saidqb.github.io
 * 
 */

namespace Saidqb\Lib\Common;


trait Url
{

	static function slug($text)
	{
		// replace non letter or digits by -
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);

		// transliterate
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

		// remove unwanted characters
		$text = preg_replace('~[^-\w]+~', '', $text);

		// trim
		$text = trim($text, '-');

		// remove duplicate -
		$text = preg_replace('~-+~', '-', $text);

		// lowercase
		$text = strtolower($text);

		if (empty($text)) {
			return 'n-a';
		}
		return $text;
	}

	static function segmentUrl($segment = 0, $urlString = '')
	{
		if (empty($urlString)) {
			$urlString = $_SERVER['REQUEST_URI'];
		}
		$uri_path = parse_url($urlString, PHP_URL_PATH);
		$uri_segments = explode('/', $uri_path);
		if (isset($uri_segments[$segment])) {
			return $uri_segments[$segment];
		}
		return '';
	}

	static function segmentUrlPrevious($segment = 0)
	{
		return static::segmentUrl($segment, url()->previous());
	}
}
