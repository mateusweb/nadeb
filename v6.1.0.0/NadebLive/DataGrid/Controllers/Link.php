<?php

namespace NadebLive\DataGrid\Controllers;

use NadebLive\Xml\ElementXml;

class Link
{
	private $element;
	public function __construct($name = '', $label = '', $action = '', array $properties = null)
	{
		$element = new ElementXml( 'a' );
		$element->href = preg_replace('/\/\//', '/', $action );
		$element->id = $name;
		$element->class = $name . ' btn btn-primary';
		$element->addElement( $label );
		if($properties) foreach ($properties as $key => $val) $element->$key = $val;

		$this->element = $element;
	}

	public function __toString()
	{
		return $this->element->__toString();
	}
}
