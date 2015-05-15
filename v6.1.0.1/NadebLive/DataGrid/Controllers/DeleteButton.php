<?php 

namespace NadebLive\DataGrid\Controllers;

use NadebLive\Xml\ElementXml;


class DeleteButton
{
	private $element;
	
	public function __construct($name = '', $label = '', array $properties = null)
	{
		$element = new ElementXml( 'input' );
		$element->type = 'submit';
		$element->id = $name;
		$element->class = $name . ' btn btn-danger';
		$element->name = $name;
		$element->value = $label;
		if($properties) foreach ($properties as $key => $val) $element->$key = $val;
		
		$this->element = $element;
	}
	
	public function __toString()
	{
		return $this->element->__toString();
	}
}
