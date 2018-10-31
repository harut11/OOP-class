<?php

spl_autoload_register(function($class_name) {
	$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . "$class_name" . '.php';
	if(file_exists($path)) {
		require_once($path);
	} else {
		echo 'Not found ' . $class_name . ' class name.';
		exit;
	}
});


$xweap = new weapons\xweap();
$ammo = new ammo();
$xweap->shoot($ammo);

//$ak74 = new weapons\automatons();
//$ammo = new ammo();
//$ak74->shoot($ammo);

//$bazuka = new weapons\bazuka();
//$whizbang = new whizbang();
//$bazuka->shoot($whizbang);

?>