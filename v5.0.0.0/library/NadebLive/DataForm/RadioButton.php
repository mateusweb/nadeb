<?php 
include_once 'Component/DataFormComponent.php';

class RadioButton extends DataFormComponent
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
		$this->element = $this->createElement( $this->getID() , $value, $this->properties );
	}
	
	protected function createElement($name, $value, $properties)
	{
		$this->name = $name;
		
		$element = new ElementXml( 'div' );
		$element->id = $name;
		$element->class = $name;
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
			$opt = new ElementXml( 'input' );
			if( $key == $value ) $opt->checked = 'checked';
			$opt->type = 'radio';
			$opt->value = $key;
			$opt->name = $element->id . '[]';

			$span = new ElementXml( 'span' );
			$span->addElement( $val );
			
			$lb = new ElementXml( 'label' );
			$lb->class = 'opt-' . (!(isset($i)) ? $i = 1 : ++$i);
			$lb->addElement( $opt . $span );
			
			$element->addElement( $lb );
		}
		
		return $element;
	}
}
