<?php
namespace NadebLive\DataForm;

use NadebLive\DataForm\Component\DataFormComponent;
use NadebLive\Xml\ElementXml;

class Select extends DataFormComponent
{
	private $options;

	public function __construct($name = '', $label = '', array $options = null, $value = '', array $properties = null)
	{
		$this->label = null;
		$this->element = null;
		$this->options = $options;
		$this->properties = $properties;

		$this->label = ($label) ? $this->createLabel( $name, $label ) : '';
		$this->element = ($name) ? $this->createElement( $name, $value, $properties ) : '';
	}

	public function changeValue($value)
	{
		$this->element = $this->createElement( $this->getName() , $value, $this->properties );
	}

	protected function createElement($name, $value, $properties)
	{
		$this->name = $name;

		$element = new ElementXml( 'select' );
		$element->id = $name;
		$element->class = $name;
		$element->name = $name;
		$element = $this->addValues( $element, $value );

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

	private function addValues(ElementXml $element, $value)
	{
		foreach ( $this->options as $key => $val )
		{
			$opt = new ElementXml( 'option' );
			if( $key == $value ) $opt->selected = 'selected';
			$opt->value = $key;
			$opt->addElement( $val );

			$element->addElement( $opt );
		}

		return $element;
	}
}
