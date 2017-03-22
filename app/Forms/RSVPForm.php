<?php

namespace Wenslijst\Forms;

use Illuminate\Support\Facades\Request;
use Session;
use Unicorn\Forms\RadioInput;
use Unicorn\Forms\SubmitButton;
use Unicorn\Forms\TextInput;
use Unicorn\UI\Bootstrap\Alert;
use Unicorn\UI\Bootstrap\ContextualStyle;
use Wenslijst\Visitor;

class RSVPForm extends LaravelForm
{
	/** @var TextInput */
	private $naam;
	
	/** @var RadioInput */
	private $aanwezig;
	
	/** @var RadioInput */
	private $eten;
	
	/** @var TextInput */
	private $aantalPersonen;
	
	/** @var TextInput */
	private $dieet;
	
	public function __construct($id, $action = null)
	{
		parent::__construct($id, $action);
		$this->noTitle();
	}
	
	public function checkAccess(): bool
	{
		return Visitor::where("ip", Request::ip())->first() === null;
	}
	
	public function title(): string
	{
		return "RSVP";
	}
	
	public function form(): void
	{
		$this->naam = new TextInput($this, "naam", "Je naam");
		$this->naam->required("Geef je naam op, anders weten wij niet wie je bent.");
		$this->addInput($this->naam);
		
		$this->aanwezig = new RadioInput($this, "aanwezig", "Ben je aanwezig?");
		$this->aanwezig->addOption("ja", "Ja");
		$this->aanwezig->addOption("nee", "Nee");
		$this->aanwezig->required("Geef aan of je aanwezig bent.");
		$this->addInput($this->aanwezig);
		
		$this->eten = new RadioInput($this, "eten", "Eet je mee?");
		$this->eten->addOption("ja", "Ja");
		$this->eten->addOption("nee", "Nee");
		$this->eten->required("Geef aan of je mee eet.");
		$this->addInput($this->eten);
		
		$this->aantalPersonen = new TextInput($this, "aantalPersonen", "Met hoeveel personen kom je?");
		$this->aantalPersonen->required("Geef aan met hoeveel personen je komt.");
		$this->addInput($this->aantalPersonen);
		
		$this->dieet = new TextInput($this, "dieet", "Heb je een speciaal dieet of allergieën?");
		$this->addInput($this->dieet);
		
		$this->setSubmitButton(new SubmitButton($this, "submit", "Geef het door"));
	}
	
	public function handle(): void
	{
		$visitor = new Visitor();
		
		$visitor->naam = $this->naam->value();
		$visitor->aanwezig = $this->aanwezig->value() == "ja";
		$visitor->eetmee = $this->eten->value() == "ja";
		$visitor->aantalPersonen = $this->aantalPersonen->value();
		$visitor->dieet = $this->dieet->value();
		$visitor->ip = Request::ip();
		
		$visitor->save();
		
		$alert = new Alert("Bedankt!", $visitor->aanwezig ? "Leuk dat je er bij bent!" : "Jammer dat je niet kan komen, zien we je nog een andere keer?", ContextualStyle::success());
		Session::flash("message", $alert->render());
	}
}
