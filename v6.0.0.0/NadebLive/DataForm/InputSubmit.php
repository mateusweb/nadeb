<?php
namespace NadebLive\DataForm;

use NadebLive\DataForm\Component\DataFormComponent;
use NadebLive\Xml\ElementXml;

class InputSubmit extends DataFormComponent
{
	public function __construct($name = '', $label = '', array $properties = null)
	{
		$this->label = null;
		$this->element = null;
		$this->properties = $properties;

		$this->element = ($name) ? $this->createElement( $name, $label, $properties ) : '';
	}

	protected function createElement($name, $value, $properties)
	{
		$this->name = $name;

		$element = new ElementXml( 'input' );
		$element->type = 'submit';
		$element->id = $name;
		$element->class = $name;
		$element->name = $name;
		$element->value = $value;
		if($properties) foreach ($properties as $key => $val) $element->$key = $val;

		return $element;
	}

	protected function createLabel($name, $label)
	{
		$lb = new ElementXml( 'label' );
		$lb->for = $name;
		$lb->class = 'label-' . $name;
		$lb->addElement( $label );

		return $lb;
	}
}
