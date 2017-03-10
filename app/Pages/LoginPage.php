<?php

namespace Wenslijst\Pages;

use Wenslijst\Forms\LoginForm;

class LoginPage extends WenslijstLayout
{
	function __construct()
	{
		parent::__construct();
		
		$this->setTitle("Login");
		
		$this->addChild($this->loginForm());
	}
	
	private function loginForm()
	{
		return new LoginForm("login");
	}
}
