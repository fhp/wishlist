<?php

namespace Wenslijst\Forms;

use Illuminate\Support\Facades\Request;
use Unicorn\Forms\SubmitButton;
use Unicorn\UI\HTML\Paragraph;
use Wenslijst\Present;

class DeletePresentForm extends LaravelForm
{
	/** @var SubmitButton */
	private $button;
	
	/** @var Present */
	private $present;
	
	public function __construct(Present $present, $action = null, $method = "POST", $encoding = "multipart/form-data", $charset = "UTF-8")
	{
		parent::__construct(str_replace("\\", "-", self::class) . "-" . $present->id, $action, $method, $encoding, $charset);
		$this->present = $present;
	}
	
	public function checkAccess(): bool
	{
		return true;
	}
	
	public function title(): string
	{
		return "Ik claim dit cadeau!";
	}
	
	public function form(): void
	{
		$this->addChild(new Paragraph("Ga je dit cadeau aanschaffen? Claim hem dan zodat anderen hem niet meer zien."));
		
		$this->button = new SubmitButton($this, "submit", "Dibs!");
		$this->setSubmitButton($this->button);
	}
	
	public function handle(): void
	{
		$this->present->ip = Request::ip();
		$this->present->save();
		
		$this->present->delete();
	}
}
