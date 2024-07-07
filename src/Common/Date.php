<?php

/**
 * @author saidqb
 * @@link http://saidqb.github.io
 *
 */

namespace Saidqb\Lib\Common;


trait Date
{
	static function now()
	{
		return date('Y-m-d H:i:s');
	}

	/**
	 * [nowPlus description]
	 * @param  [type] $val    [int time]
	 * @param  [type] $format [P[int]Y[int]M[int]DT[int]H[int]M[int]S]
	 * @return [type]         [date]
	 */
	static function nowPlus($val, $format = 'PD')
	{
		$arr = [
			'PY' => 'Y',
			'PM' => 'M',
			'PD' => 'D',
			'TH' => 'H',
			'TM' => 'M',
			'TS' => 'S',
		];
		$arrKey = array_keys($arr);
		if (!in_array($format, $arrKey)) {
			return '';
		}
		$date = new \DateTime(self::now());
		if (in_array($format, ['PY', 'PM', 'PD'])) $interval = new \DateInterval('P' . $val . $arr[$format]);
		if (in_array($format, ['TH', 'TM', 'TS'])) $interval = new \DateInterval('PT' . $val . $arr[$format]);

		$date->add($interval);
		return  $date->format('Y-m-d H:i:s');
	}

	static function timestamp()
	{
		$date_timestamp = new \DateTime();
		return $date_timestamp->format('U');
	}
	static function timestampTo($timestamp, $type = 'datetime')
	{
		if ($type == 'datetime') {
			return date('Y-m-d H:i:s', strtotime($timestamp));
		}
		if ($type == 'date') {
			return date('Y-m-d', strtotime($timestamp));
		}
	}

	static function convertMonth($month, $lang = 'id')
	{
		$month = (int) $month;
		switch ($lang) {
			case 'id':
				$arr_month = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'Nopember', 'Desember');
				break;

			default:
				$arr_month = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
				break;
		}
		$month_converted = $arr_month[$month - 1];

		return $month_converted;
	}

	static function listMonth()
	{
		$arr_month = array(
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);

		return $arr_month;
	}

	static function indoDate($tanggal, $time = true)
	{
		$bulan = array(
			1 =>   'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$tanggalArr = explode(' ', $tanggal);
		if (count($tanggalArr) > 1) {
			$split = explode('-', $tanggalArr[0]);
			$newDate = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
			if ($time) {
				$newDate = $newDate . ' ' . $tanggalArr[1];
			}
		} else {
			$split = explode('-', $tanggalArr[0]);
			$newDate = $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
		}


		return $newDate;
	}

	static function indoDay($datetime, $format = 'indo')
	{
		$day = date("D", strtotime($datetime));

		switch ($day) {
			case 'Sun':
				$dayname = "Minggu";
				break;

			case 'Mon':
				$dayname = "Senin";
				break;

			case 'Tue':
				$dayname = "Selasa";
				break;

			case 'Wed':
				$dayname = "Rabu";
				break;

			case 'Thu':
				$dayname = "Kamis";
				break;

			case 'Fri':
				$dayname = "Jumat";
				break;

			case 'Sat':
				$dayname = "Sabtu";
				break;

			default:
				$dayname = "Tidak di ketahui";
				break;
		}

		return $dayname;
	}

	static function indoDateObj($datetime)
	{
		$obj = [];
		$obj['month'] = self::convertMonth(date('m', strtotime($datetime)));
		$obj['date_text'] = self::indoDate($datetime, false);
		$obj['date_number'] = date('d-m-Y', strtotime($datetime));
		$obj['time'] = date('H:i', strtotime($datetime));
		$obj['day'] = self::indoDay($datetime);
		return (object)$obj;
	}

	static function validateDate($date, $format = 'Y-m-d')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) === $date;
	}
}
