<?php

define('BASE_PATH', dirname(dirname(__FILE__)));

require_once(BASE_PATH . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'functions.php');

spl_autoload_register(function($class) {
	$class = base_path($class) . '.php';
	if (file_exists($class)) {
		require_once($class);
	} else {
		echo "Class $class does not exist";
		exit;
	}
});

get_router();

$date = new core\SuperDate(date('Y-m-d H:i:s'));
print_r($date->diff('2018-11-13 18:49:00'));