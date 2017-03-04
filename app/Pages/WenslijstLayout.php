<?php

namespace Wenslijst\Pages;

use Unicorn\UI\Base\HtmlElement;
use Unicorn\UI\Base\HtmlPage;

class WenslijstLayout extends HtmlPage
{
	function __construct()
	{
		$content = new HtmlElement("div");
		$content->addClass("container");
		
		parent::__construct($content);
		
		$body = $this->body();
		$body->addChild($content);
		
		$this->addJavascript("https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js");
		$this->addJavascript("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js");
		$this->addStylesheet("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css");
		$this->addStylesheet("test.css");
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
