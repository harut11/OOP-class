<?php

namespace app\controllers;

use core\baseController;
use core\session;
use app\models\users;

class UserController extends baseController
{
	public function login()
	{
		return view('user.login', 'Welcome to login page!');
	}

	public function loginSubmit()
	{

	}

	public function register()
	{
		return view('user.register', 'Welcome to register page!');
	}

	public function registerSubmit()
	{
		$this->validate($_REQUEST, [
			'first_name' => 'required|min:2|max:100',
			'last_name' => 'required|min:2|max:100',
			'email' => 'required|email|unique:users,email',
			'password' => 'required|min:6|max:32|confirmed',
		]);
		$result = users::query()->create([
			'first_name' => $_REQUEST['first_name'],
			'last_name' => $_REQUEST['last_name'],
			'email' => $_REQUEST['email'],
			'password' => encrypt($_REQUEST['password']),
		]);
	}
}