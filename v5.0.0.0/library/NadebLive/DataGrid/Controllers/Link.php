<?php 

class Link
{
	private $element;
	
	public function __construct($name = '', $label = '', $action = '')
	{
		$element = new ElementXml( 'a' );
		$element->href = $action;
		$element->id = $name;
		$element->class = $name;
		$element->addElement( $label );
		
		$this->element = $element;
	}
	
	public function __toString()
	{
		return $this->element->__toString();
	}
}
