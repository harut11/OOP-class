<?php

namespace core;

class View
{
	protected $contents = '';

	public function render($view, $title = '')
	{
		$pageView = $this->getView($view);
		$pageTitle = $title;
		$layout = $this->getView('layouts.main');
		$this->contents = str_replace('@content', $pageView, $layout);
		$this->contents = str_replace('@title', $pageTitle, $this->contents);
		return $this;
	}

	public function renderPartial($view)
	{
		return $this->getView($view);
	}

	protected function getView(string $view_name)
	{
		$path = views_path(str_replace('.', '/', $view_name) . '.php');
		if (file_exists($path)) {
			ob_start();
			require($path);
			return ob_get_clean();
		}
		return null;
	}

	public function __toString()
	{
		return $this->contents;
	}
}