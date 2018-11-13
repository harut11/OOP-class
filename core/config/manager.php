<?php

namespace core\config;

use core\SingletoneTrait;

class manager
{
	use SingletoneTrait;

	private $configs = [
		'main',
		'main-local.php'
	];

	private $loaded_configuration = [];

	private function __construct()
	{
		foreach ($configs as $config) {
			$this->loaded_configuration[$config] = [];
			$path = base_path('config/' . $config . '.php');
			if (file_exists($path)) {
				$this->loaded_configuration[$config] = array_replace_recursive($this->loaded_configuration[$config], require_once($path));
			} else {
				echo 'Confin file for $config not found!';
				exit;
			}

			$local_path = base_path('config/' . $config . '-local.php');
			if (file_exists($local_path)) {
				$this->loaded_configuration[$config] = array_replace_recursive($this->loaded_configuration[$config], require_once($local_path));
			}
		}
	}

	public static function get($key)
	{
		$configs = self::getInstance()->loaded_configuration;
		$parts = explode('.', $key);
		foreach ($parts as $part) {
			$configs = !empty($configs[$part]) ? $configs[$part] : null;
		}
		return $configs;
	}

}