<?php 
include_once 'DataGrid/Component/SearchFormComponent.php';

class SelectSearch extends SearchFormComponent
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
	
	protected function createElement($name, $value, $properties)
	{
		$element = new ElementXml( 'select' );
		$element->id = $name;
		$element->class = 'selectSearch';
		$element->name = $name;
		$element = $this->addValues( $element, $value );
		
		if($properties) foreach ($properties as $key => $val) $element->$key = $val;
		
		$dt = $this->crateDT( $element );
		$dd = $this->crateDD( $element );
		
		return $dt . $dd;
	}
	
	protected function crateDT(ElementXml $element)
	{
		$dt = new ElementXml( 'dt' );
		$dt->id = $element->id . '-label';
		$dt->class = $element->id . '-label';
		$dt->addElement( $this->label );
	
		return $dt;
	}
	
	protected function crateDD(ElementXml $element)
	{
		$dd = new ElementXml( 'dd' );
		$dd->id = $element->id . 'Param';
		$dd->class = $element->id . '-object';
		$dd->addElement( $element );
	
		return $dd;
	}
	
	private function addValues(ElementXml $element, $value)
	{
		if( $this->options )
		{
			foreach ( $this->options as $key => $val )
			{
				$opt = new ElementXml( 'option' );
				if( $key == $value ) $opt->selected = 'selected';
				$opt->value = $key;
				$opt->addElement( $val );
					
				$element->addElement( $opt );
			}
		}
		$element->addElement( '' );
		return $element;
	}
}
