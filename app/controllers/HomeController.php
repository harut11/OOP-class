<?php

namespace app\controllers;

use core\baseController;

class HomeController extends baseController
{
	public function index()
	{
		echo view('home.index', 'Welcome to Home!');
	}
}