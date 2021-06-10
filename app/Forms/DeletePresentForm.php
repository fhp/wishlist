<?php

namespace Wenslijst\Forms;

use Illuminate\Support\Facades\Auth;
use Unicorn\Forms\SubmitButton;
use Unicorn\UI\HTML\Paragraph;
use Unicorn\Forms\TextInput;
use Wenslijst\Present;

class DeletePresentForm extends LaravelForm
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
		return Auth::check();
	}
	
	public function title(): string
	{
		return "Weg ermee!";
	}
	
	public function form(): void
	{
		$this->addChild(new Paragraph("Heb je {$this->present->name} toch niet nodig?"));

		if ($this->present->bever !== null) {
			$this->addChild(new Paragraph("Vertel je de ouders van {$this->present->bever} ook even dat ze dit niet mee hoeven te geven?"));
		}
		
		$this->button = new SubmitButton($this, "submit", "Weg ermee!");
		$this->setSubmitButton($this->button);
	}
	
	public function handle(): void
	{
		$this->present->forceDelete();
	}
}
