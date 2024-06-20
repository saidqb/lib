<?php

/**
 * @author saidqb
 * @@link http://saidqb.github.io
 * 
 */

namespace Saidqb\Lib\Common;


trait Accounting
{
	/**
	 * [generateDiscount description]
	 * @param  [type] $price    [description]
	 * @param  [type] $discount [description]
	 * @param  string $type     [description]
	 * @return [type]           [description]
	 * price_origin
	 * output array:
		price
		discount_nominal
		discount_percent
		is_discount
		type
	-
	 */


	static function generateDiscount($price, $discount, $type = 'nominal')
	{
		$arr = [];

		$arr['price_origin'] = $price;
		$arr['price'] = $price;
		$arr['discount_nominal'] = 0;
		$arr['discount_percent'] = 0;
		$arr['is_discount'] = 0;

		if ($discount > 0) {
			if ($type == 'nominal') {
				$arr['discount_nominal'] = $discount;
				$new = $price - $discount;
				$arr['discount_percent'] = ($price - $new) / $price * 100;
			}
			if ($type == 'percent') {
				$arr['discount_nominal'] = ($discount / 100) * $price;
				$arr['discount_percent'] = $discount;
			}
			$arr['is_discount'] = 1;
			$arr['price'] = $arr['price'] - $arr['discount_nominal'];
		}
		$arr['type'] = $type;

		return $arr;
	}
}
