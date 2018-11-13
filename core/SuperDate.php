<?php

namespace core;

class SuperDate
{
	private $year;
	private $month;
	private $day;
	private $hour;
	private $minute;
	private $second;

	public function __construct($date = '')
	{
		if (!$date) {
			$date = date('Y-m-d h:i:s');
		}
		$this->parseFromString($date);
	}

	public function parseFromString($string)
	{
		$dayMinute = explode(' ', $string);
		if (count($dayMinute) < 2) {
			$dayMinute[] = '00:00:00';
		}
		$ymd = explode('-', $dayMinute[0]);
		$his = explode(':', $dayMinute[1]);

		$this->year = $ymd[0];
		$this->month = $this->validateMonths($ymd[1]);
		$this->day = $this->validateDays($ymd[2]);

		$this->hour = $this->validateHours($his[0]);
		$this->minute = $this->validateMinutes($his[1]);
		$this->second = $this->validateSeconds($his[2]);

		$this->calculateTimestamp();
	}

	public function __call($method_name, $arguments)
	{
		if (preg_match('/^validate(Seconds|Minutes|Hours|Days|Months)$/', $method_name, $matches)) {
			$what = strtolower($matches[1]);
			$max = $this->getMaxFor($what);
			return $this->validate($arguments[0] , $max, $what);
		} else {
			echo $method_name . 'method can not be found!';
		}
	}

	public function diff($date = null)
	{
		$dateToCompare = new self($date);
		$diff = $this->timestamp - $dateToCompare->timestamp;
		$future = false;
		if ($diff < 0) {
			$diff = -$diff;
			$future = true;
		}
		$diff = $this->ParseDiff($diff);
		$text = $future ? 'in ' : '';
		$text .= $diff['value'] . ' ' . $diff['text'] . ($diff['value'] > 1 ? 's' : '');
		$text .= $future ? '' : ' ago';
		return $text;
	}

	public function parseDiff($diff)
	{
		if ($diff > 365 * 24 * 3600) {
			$years = floor($diff / (365 * 24 *3600));
			return [
				'value' => $years,
				'text' => 'year',
			];
		} else if ($diff > 30*24*3600) {
			$months = floor($diff / (30 * 24 *3600));
			return [
				'value' => $months,
				'text' => 'month',
			];
		} else if ($diff > 7*24*3600) {
			$weeks = floor($diff / (7 * 24 * 3600));
			return [
				'value' => $weeks,
				'text' => 'week',
			];
		} else if ($diff > 24 * 3600) {
			$days = floor($diff / (24 * 3600));
			return [
				'value' => $days,
				'text' => 'day',
			];
		} else if ($diff > 3600) {
			$hours = floor($diff / 3600);
			return [
				'value' => $hours,
				'text' => 'hour',
			];
		} else if ($diff > 60) {
			$minutes = floor($diff / 60);
			return [
				'value' => $minutes,
				'text' => 'minute',
			];
		} else {
			return [
				'value' => $diff,
				'text' => 'second',
			];
		}
	}

	public function calculateTimestamp()
	{
		$daysPassed = 0;
		for ($i = 1970; $i < $this->year; $i++) {
			$daysPassed += $this->isLeapYear($i) ? 366 : 365;
		}

		for ($i = 1; $i < $this->month; $i++) {
			$daysPassed += $this->getMaxDaysForMonth($i);
		}
		$daysPassed += ($this->day - 1);
		$secondPassed = $daysPassed * 24 * 3600;
		$secondPassed += $this->hour * 3600 + $this->minute * 60 + $this->second;
		$this->timestamp = $secondPassed;
	}

	public function getMaxFor($what)
	{
		switch ($what) {
			case 'seconds':
			case 'minutes':
				return 60;
			case 'hours':
				return 24;
			case 'days':
				return $this->getMaxDaysForMonth();
			case 'months':
				return 12;
		}
	}

	public function validate($value, $max, $name)
	{
		if ($value > $max || $value < 0) {
			echo 'Invalid value vor' . $name;
			exit;
		}
		return (int)$value;
	}

	public function isLeapYear($year = null)
	{
		$year = $year ? $year : $this->year;
		return $this->year%4 === 0;
	}

	private function getMaxDaysForMonth($month = null)
	{
		$month = $month ? $month : $this->month;
		if (in_array($month, [1, 3, 5, 7, 8, 10, 12])) {
			return 31;
		} else if (in_array($month, [4, 6, 9, 11])) {
			return 30;
		} else {
			if ($this->isLeapYear()) {
				return 29;
			} else {
				return 28;
			}
		}
	
	}

	public function add($number, $what)
	{
		switch ($what) {
			case 'seconds':
				$this->second = $this->second + $number;
				if ($this->second > 59) {
					$this->second = $this->second - 60;
					$this->add(1, 'minutes');
				}
				break;
			case 'minutes':
				$this->minute = $this->minute + $number;
				if ($this->minute > 59) {
					$this->minute = $this->minute - 60;
					$this->add(1, 'hours');
				}
				break;
			case 'hours':
				$this->hour = $this->hour + $number;
				if ($this->hour > 23) {
					$this->hour = $this->hour - 24;
					$this->add(1, 'days');
				}
				break;
			case 'days':
				$this->day = $this->day + $number;
				if ($this->day > $this->getMaxDaysForMonth()) {
					$this->day = $this->day - $this->getMaxDaysForMonth();
					$this->add(1, 'months');
				}
				break;
			case 'months':
				$this->month = $this->month + $number;
				if ($this->month > 12) {
					$this->month = $this->monyh - 12;
					$this->add(1, 'years');
				}
				break;
			case 'years':
				$this->year = $this->year + $number;
				break;
			default:
				break;
		}
	}
}