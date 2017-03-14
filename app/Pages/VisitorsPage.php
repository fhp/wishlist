<?php

namespace Wenslijst\Pages;

use Unicorn\UI\Base\Widget;
use Unicorn\UI\Bootstrap\BoolCheck;
use Unicorn\UI\Bootstrap\OrmTable;
use Wenslijst\Visitor;

class VisitorsPage extends WenslijstLayout
{
	function __construct()
	{
		parent::__construct();
		
		$this->setTitle("Bezoekers");
		
		$this->addChild($this->visitorsList());
	}
	
	private function visitorsList(): Widget
	{
		$table = new OrmTable(Visitor::all());
		$table->addColumnFunction("Naam", function(Visitor $visitor) { return $visitor->naam; });
		$table->addColumnFunction("Komt?", function(Visitor $visitor) { return new BoolCheck($visitor->aanwezig); });
		$table->addColumnFunction("Eet mee?", function(Visitor $visitor) { return new BoolCheck($visitor->eetmee); });
		$table->addColumnFunction("Aantal mensen?", function(Visitor $visitor) { return (string)$visitor->aantalPersonen; });
		$table->addColumnFunction("Allergie of dieet?", function(Visitor $visitor) { return $visitor->dieet; });
		
		return $table;
	}
}
