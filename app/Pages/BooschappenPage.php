<?php

namespace Wenslijst\Pages;

use Unicorn\UI\Base\Widget;
use Unicorn\UI\Bootstrap\Alert;
use Unicorn\UI\Bootstrap\ContextualStyle;
use Unicorn\UI\Bootstrap\ModalForm;
use Unicorn\UI\Bootstrap\OrmTable;
use Unicorn\UI\HTML\Header;
use Unicorn\UI\HTML\Link;
use Wenslijst\Forms\DeletePresentForm;
use Wenslijst\Present;
use Wenslijst\Forms\NewPresentForm;
use Wenslijst\UI\DeleteIcon;

class BooschappenPage extends WenslijstLayout
{
	function __construct()
	{
		parent::__construct();
		
		$this->setTitle("Boodschappen");
		
		$this->addChild(new Header("Boodschappen", "h1", "Wie neemt wat mee?"));
		$this->addChild(new Header("Geregeld", "h2", "Een van de bevers neemt dit mee!"));
		$this->addChild($this->boodschappenDoneList());
		$this->addChild(new Header("Nog nodig", "h2", "Dit is nog niet geregeld."));
		$this->addChild($this->boodschappenTodoList());
		$this->addChild(new NewPresentForm("newPresent"));
	}
	
	private function boodschappenDoneList(): Widget
	{
		$presents = Present::onlyTrashed()->get();
		if($presents->count() == 0) {
			return new Alert("Helaas:", "Er zijn nog geen bevers die iets meenemen.", ContextualStyle::info());
		}
		$table = new OrmTable($presents);
		$table->addColumnFunction("Product", function(Present $present) {
			if($present->url === null) {
				return $present->name;
			} else {
				$link = new Link($present->url);
				$link->openInNewPage();
				$link->addText($present->name);
				return $link;
			}
		});
		$table->addColumnFunction("Omschrijving", function(Present $present) { return $present->omschrijving; });
		$table->addColumnFunction("Bever", function(Present $present) { return $present->bever === null ? '?' : $present->bever; });
		$table->addColumnFunction("Verwijderen?", function(Present $present) {
			$modal = new ModalForm(new DeletePresentForm($present));
			$modal->includeToggleButton("Weg ermee", new DeleteIcon());
			$modal->addCloseButton("Ik denk er nog even over na");
			return $modal;
		});
		
		return $table;
	}

	private function boodschappenTodoList(): Widget
	{
		$presents = Present::all();
		if($presents->count() == 0) {
			return new Alert("Klaar:", "Alle boodschappen zijn verzorgt. Nog iets nodig? Voeg het hieronder dan toe.", ContextualStyle::info());
		}
		$table = new OrmTable($presents);
		$table->addColumnFunction("Product", function(Present $present) {
			if($present->url === null) {
				return $present->name;
			} else {
				$link = new Link($present->url);
				$link->openInNewPage();
				$link->addText($present->name);
				return $link;
			}
		});
		$table->addColumnFunction("Omschrijving", function(Present $present) { return $present->omschrijving; });
		$table->addColumnFunction("Verwijderen?", function(Present $present) {
			$modal = new ModalForm(new DeletePresentForm($present));
			$modal->includeToggleButton("Weg ermee", new DeleteIcon());
			$modal->addCloseButton("Ik denk er nog even over na");
			return $modal;
		});

		return $table;
	}
}
