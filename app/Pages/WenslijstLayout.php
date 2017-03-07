<?php

namespace Wenslijst\Pages;

use Illuminate\Support\Facades\Auth;
use Unicorn\UI\Base\HtmlElement;
use Unicorn\UI\Base\HtmlPage;
use Unicorn\UI\Bootstrap\Button;
use Unicorn\UI\Bootstrap\LinkButton;
use Unicorn\UI\Bootstrap\Navbar;
use Unicorn\UI\HTML\Header;

class WenslijstLayout extends HtmlPage
{
	function __construct()
	{
		$content = new HtmlElement("div");
		$content->addClass("container");
		
		parent::__construct($content);
		
		$bar = new Navbar();
		$bar->brandLink("Wenslijst", route("home"));
		if(Auth::check()) {
			$bar->addButton(new LinkButton(route("logout"), "logout"), true);
		} else {
			$bar->addButton(new LinkButton(route("login"), "login"), true);
		}
		$this->body()->addChild($bar);
		
		$this->body()->addChild($content);
		
		$this->addJavascript("https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js");
		$this->addJavascript("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js");
		$this->addStylesheet("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css");
		$this->addStylesheet("test.css");
		
		$this->addChild(new Header("Wenslijst", "h1", "Ideeën voor Jace, Nadine en/of Stef"));
	}
	
	protected function setTitle(string $title): void
	{
		parent::setTitle("Test - " . $title);
	}
	
	protected function lipsum(): string
	{
		return file_get_contents("http://loripsum.net/api/1/plaintext");
	}
}
