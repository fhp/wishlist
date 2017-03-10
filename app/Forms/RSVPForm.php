<?php

namespace Wenslijst\Forms;

use Unicorn\Forms\RadioInput;
use Unicorn\Forms\SubmitButton;
use Unicorn\Forms\TextInput;

class RSVPForm extends LaravelForm
{
	private $aanwezig;
	private $eten;
	private $aantalPersonen;
	private $dieet;
	
	public function checkAccess(): bool
	{
		return true;
	}
	
	public function title(): string
	{
		return "RSVP";
	}
	
	public function form(): void
	{
		$this->aanwezig = new RadioInput("aanwezig", "Ben je aanwezig?");
		$this->aanwezig->addOption("ja", "Ja");
		$this->aanwezig->addOption("nee", "Nee");
		$this->addInput($this->aanwezig);
		
		$this->eten = new RadioInput("eten", "Eet je mee?");
		$this->eten->addOption("ja", "Ja");
		$this->eten->addOption("nee", "Nee");
		$this->addInput($this->eten);
		
		$this->aantalPersonen = new TextInput("aantalPersonen", "Met hoeveel personen kom je?");
		$this->addInput($this->aantalPersonen);
		
		$this->dieet = new TextInput("dieet", "Heb je een speciaal dieet of allergieën?");
		$this->addInput($this->dieet);
		
		$this->setSubmitButton(new SubmitButton("submit", "Geef het door"));
	}
	
	public function handle(): void
	{
		// TODO: Implement handle() method.
	}
}
