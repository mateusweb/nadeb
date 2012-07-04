<?php 
include_once 'Component/DataFormComponent.php';

class TextArea extends DataFormComponent
{
	protected function createElement($name, $value, $properties)
	{
		$this->name = $name;
		$this->properties = $properties;
		
		$element = new ElementXml( 'textarea' );
		$element->id = $name;
		$element->class = $name;
		$element->name = $name;
		$element->rows = 4;
		$element->cols = 50;
		$element->addElement( $value );
		
		if($properties) foreach ($properties as $key => $val) $element->$key = $val;
	
		return $element;
	}
	
	public function changeValue($value)
	{
		$this->element = $this->createElement( $this->getName() , $value, $this->properties );
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

	
