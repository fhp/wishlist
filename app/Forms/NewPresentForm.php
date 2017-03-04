<?php

namespace Wenslijst\Forms;

use Unicorn\Forms\Conditions\InputNotEmpty;
use Unicorn\Forms\TextInput;
use Unicorn\Forms\SubmitButton;
use Wenslijst\Present;

class NewPresentForm extends CsrfProtectedForm
{
	/** @var TextInput */
	private $name;
	
	/** @var TextInput */
	private $ontvanger;
	
	/** @var TextInput */
	private $omschrijving;
	
	/** @var SubmitButton */
	private $button;
	
	public function checkAccess(): bool
	{
		return true;
	}
	
	public function title(): string
	{
		return "Cadeau toevoegen";
	}
	
	public function form(): void
	{
		$this->name = new TextInput("name", "Cadeau");
		$this->ensure(new InputNotEmpty($this->name, "Geen een naam op"));
		$this->addInput($this->name);
		
		$this->ontvanger = new TextInput("ontvanger", "Ontvanger");
		$this->ensure(new InputNotEmpty($this->ontvanger, "Geen een ontvanger op"));
		$this->addInput($this->ontvanger);
		
		$this->omschrijving = new TextInput("omschrijving", "Omschrijving");
		$this->ensure(new InputNotEmpty($this->omschrijving, "Geen een omschrijving op"));
		$this->addInput($this->omschrijving);
		
		$this->button = new SubmitButton("submit", "Submit");
		$this->addInput($this->button);
	}
	
	public function handle(): void
	{
		$present = new Present();
		$present->name = $this->name->value();
		$present->ontvanger = $this->ontvanger->value();
		$present->omschrijving = $this->omschrijving->value();
		$present->save();
	}
}
