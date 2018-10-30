<?php

spl_autoload_extensions(function($class_name) {
	$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . "$class_name" . '.php';
	if(file_exists($path)) {
		require_once($path);
	} else {
		echo 'Not found' . $class_name . 'class name.';
		exit;
	}
})
