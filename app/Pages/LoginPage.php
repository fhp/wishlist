<?php

namespace Wenslijst\Pages;

use Unicorn\UI\HTML\Header;
use Wenslijst\Forms\LoginForm;

class LoginPage extends WenslijstLayout
{
	function __construct()
	{
		parent::__construct();
		
		$this->setTitle("Login");
		
		$this->addChild(new Header("Login", "h1", "Alleen voor de beverleiding."));
		$loginForm = $this->loginForm();
		$loginForm->noTitle();
		$this->addChild($loginForm);
	}
	
	private function loginForm()
	{
		return new LoginForm("login");
	}
}
