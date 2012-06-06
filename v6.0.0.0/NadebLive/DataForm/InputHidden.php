<?php
namespace NadebLive\DataForm;

use NadebLive\DataForm\Component\DataFormComponent;
use NadebLive\Xml\ElementXml;

class InputHidden extends DataFormComponent
{
	public function __construct($name = '', $value = '', array $properties = null )
	{
		$this->label = null;
		$this->element = null;

		$this->element = ($name) ? $this->createElement( $name, $value, $properties ) : '';

	}

	protected function createElement($name, $value, $properties)
	{
		$this->name = $name;

		$element = new ElementXml( 'input' );
		$element->type = 'hidden';
		$element->id = $name;
		$element->name = $name;
		$element->value = $value;
		if($properties) foreach ($properties as $key => $val) $element->$key = $val;

		return $element;
	}

	protected function createLabel($name, $label)
	{
		return false;
	}
}


