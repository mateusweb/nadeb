<?php
namespace NadebLive\DataForm;

use NadebLive\DataForm\Component\DataFormComponent;
use NadebLive\Xml\ElementXml;

class InputPassword extends DataFormComponent
{
	protected function createElement($name, $value, $properties)
	{
		$this->name = $name;

		$element = new ElementXml( 'input' );
		$element->type = 'password';
		$element->id = $name;
		$element->class = $name;
		$element->name = $name;
		$element->value = $value;
		if($properties) foreach ($properties as $key => $val) $element->$key = $val;

		return $element;
	}

	public function changeValue($value)
	{
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
