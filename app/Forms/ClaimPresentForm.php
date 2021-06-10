<?php

namespace Wenslijst\Forms;

use Illuminate\Support\Facades\Request;
use Unicorn\Forms\SubmitButton;
use Unicorn\UI\HTML\Paragraph;
use Unicorn\Forms\TextInput;
use Wenslijst\Present;

class ClaimPresentForm extends LaravelForm
{
	/** @var SubmitButton */
	private $button;
	
	/** @var Present */
	private $present;

	/** @var TextInput */
	private $bever;
	
	public function __construct(Present $present, $action = null)
	{
		$this->present = $present;
		parent::__construct(str_replace("\\", "-", self::class) . "-" . $present->id, $action);
	}
	
	public function checkAccess(): bool
	{
		return true;
	}
	
	public function title(): string
	{
		return "Ik neem dit mee!";
	}
	
	public function form(): void
	{
		$this->addChild(new Paragraph("Neem jij {$this->present->name} mee? Fijn!"));
		$this->addChild(new Paragraph("Vul hier nog even de naam van je bever in, dan weten we wat we van wie kunnen verwachten."));
		$this->addChild(new Paragraph("En maak zelf even een aantekening wat je mee geeft aan je bever. Dit kun je hier namelijk niet meer zien."));
		
		$this->bever = new TextInput($this, "bever", "Naam van de bever");
		$this->addInput($this->bever);

		$this->button = new SubmitButton($this, "submit", "Ga ik regelen!");
		$this->setSubmitButton($this->button);
	}
	
	public function handle(): void
	{
		$this->present->ip = Request::ip();
		$this->present->bever = $this->bever->value();
		$this->present->save();
		
		$this->present->delete();
	}
}
