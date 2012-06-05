<?php 
include_once 'Component/DataFormComponent.php';

class InputText extends DataFormComponent
{
	protected function createElement($name, $value, $properties)
	{
		$this->name = $name;
		
		$element = new ElementXml( 'input' );
		$element->type = 'text';
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
