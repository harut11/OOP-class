<?php

function replace_separators($path) {
	return preg_replace('#[\\\/]#', DIRECTORY_SEPARATOR, $path);
}

function base_path($path) {
	return replace_separators(BASE_PATH . '/' . $path);
}

function app_path($path) {
	return base_path('app/' . $path);
}

function views_path($path) {
	return app_path('views/' . $path);
}

function get_config($key) {
	return core\config\manager::get($key);
}

function get_connection() {
	return core\database\connection::getInstance();
}

function view($view) {
	$v = new core\View();
	return $v->render($view);
}

function view_Partial($view) {
	$vp = new core\View();
	return $vp->renderPartial($view);
}

function dd(... $values) {
	foreach ($values as $value) {
		var_dump($value);
	}
	die();
}

function get_router() {
	return core\router::getInstance();
}

function kebabToCamel($string) {
	$parts = explode('-', $string);
	foreach ($parts as $key => $part) {
		if ($key !== 0) {
			$parts[$key] = ucfirst($part);
		}
	}

	return implode('', $parts);
}

function redirect($url) {
	return new core\redirector($url);
}

function encrypt($test) {
	$newText = '';
	for ($i = 0; $i < strlen($text); $i++) {
		$newText .= $text[$i] . $i;
		return sha1($newText);
	}
}