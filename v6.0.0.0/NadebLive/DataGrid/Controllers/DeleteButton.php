<?php 

namespace NadebLive\DataGrid\Controllers;

use NadebLive\Xml\ElementXml;


class DeleteButton
{
	private $element;
	
	public function __construct($name = '', $label = '')
	{
		$element = new ElementXml( 'input' );
		$element->type = 'submit';
		$element->id = $name;
		$element->class = $name;
		$element->name = $name;
		$element->value = $label;
		
		$this->element = $element;
	}
	
	public function __toString()
	{
		return $this->element->__toString();
	}
}
