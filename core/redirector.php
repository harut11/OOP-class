<?php

namespace core;

class redirector
{
	private $url;

	public function __constract($url)
	{
		$this->url = $url;
	}

	public function setHeader()
	{
		header('Location: ' . $this->url);
		return $this;
	}
}