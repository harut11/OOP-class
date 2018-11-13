<?php

namespace core;

class router
{
	use SingletonTrait;

	private function __construct()
	{
		$session = new session();
		$uri = $_SERVER['REQUEST_URI'];
		$action = $this->getActionName();
		$result = $this->getController()->$action();
		if (is_object($result)) {
			switch (get_class($result)) {
				case 'core\\View':
					echo $result;
					break;
				case 'core\\redirector':
					$result->setHeader();
					break;
				default:
					break;
			}
		}
	}

	private function getController() : baseController
	{
		$uri = $_SERVER['REQUEST_URI'];
		$parts = array_values(array_filter(explode('/', $uri)));
		$controllerName = !empty($parts[0]) ? ucfirst($parts[0]) : 'home';
		$controllerClassName = "\\app\\controllers\\{$controllerName}Controller";
		return new $controllerClassName();
	}

	private function getActionName()
	{
		$uri = $_SERVER['REQUEST_URI'];
		$parts = array_values(array_filter(explode('/', $uri)));
		return count($parts) > 1 ? kebabToCamel($parts[1]) : 'index';
	}
}