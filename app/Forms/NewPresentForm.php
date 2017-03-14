<?php

namespace Wenslijst\Forms;

use Illuminate\Support\Facades\Auth;
use Unicorn\Forms\Conditions\InputNotEmpty;
use Unicorn\Forms\TextInput;
use Unicorn\Forms\SubmitButton;
use Wenslijst\Present;

class NewPresentForm extends LaravelForm
{
	/** @var TextInput */
	private $name;
	
	/** @var TextInput */
	private $ontvanger;
	
	/** @var TextInput */
	private $omschrijving;
	
	/** @var TextInput */
	private $url;
	
	/** @var SubmitButton */
	private $button;
	
	public function checkAccess(): bool
	{
		return Auth::check();
	}
	
	public function title(): string
	{
		return "Cadeau toevoegen";
	}
	
	public function form(): void
	{
		$this->name = new TextInput($this, "name", "Cadeau");
		$this->ensure(new InputNotEmpty($this->name, "Geef een naam op"));
		$this->addInput($this->name);
		
		$this->ontvanger = new TextInput($this, "ontvanger", "Ontvanger");
		$this->ensure(new InputNotEmpty($this->ontvanger, "Geef een ontvanger op"));
		$this->addInput($this->ontvanger);
		
		$this->omschrijving = new TextInput($this, "omschrijving", "Omschrijving");
		$this->addInput($this->omschrijving);
		
		$this->url = new TextInput($this, "url", "Link");
		$this->addInput($this->url);
		
		$this->button = new SubmitButton($this, "submit", "Submit");
		$this->addInput($this->button);
	}
	
	public function handle(): void
	{
		$present = new Present();
		$present->name = $this->name->value();
		$present->ontvanger = $this->ontvanger->value();
		$present->omschrijving = $this->omschrijving->value();
		$present->url = ($this->url->value() == "" ? null : $this->url->value());
		$present->save();
	}
}
