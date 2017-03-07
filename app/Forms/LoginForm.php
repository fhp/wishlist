<?php

namespace Wenslijst\Forms;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Unicorn\Forms\Conditions\InputNotEmpty;
use Unicorn\Forms\PasswordInput;
use Unicorn\Forms\SubmitButton;
use Unicorn\Forms\TextInput;
use Wenslijst\Http\PageFlowException;

class LoginForm extends CsrfProtectedForm
{
	/** @var TextInput */
	private $username;
	
	/** @var TextInput */
	private $password;
	
	public function checkAccess(): bool
	{
		return true;
	}
	
	public function title(): string
	{
		return "Login";
	}
	
	public function form(): void
	{
		$this->username = new TextInput("username", "Gebruikersnaam");
		$this->ensure(new InputNotEmpty($this->username, "Geen een gebruikersnaam op."));
		$this->addInput($this->username);
		
		$this->password = new PasswordInput("password", "Wachtwoord");
		$this->ensure(new InputNotEmpty($this->password, "Geen een wachtwoord op."));
		$this->addInput($this->password);
		
		$this->setSubmitButton(new SubmitButton("submit", "Submit"));
	}
	
	public function handle(): void
	{
		if (Auth::attempt(['email' => $this->username->value(), 'password' => $this->password->value()])) {
			throw new PageFlowException(redirect()->route("home"));
		} else {
			$this->username->error("Deze gebruikersnaam en wachtwoord combinatie is incorrect.");
		}
	}
}
