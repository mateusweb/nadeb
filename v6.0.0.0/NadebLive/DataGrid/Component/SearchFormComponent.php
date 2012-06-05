<?php 
include 'DataGrid/Interfaces/SearchFormElementInterface.php';

abstract class SearchFormComponent implements SearchFormElementInterface
{
	protected $element;
	protected $label;
	protected $properties;
	
	public function __construct($name = '', $label = '', $value = '', array $properties = null)
	{
		$this->label = null;
		$this->element = null;
		$this->properties = $properties;

		$this->label = ($label) ? $this->createLabel( $name, $label ) : '';
		$this->element = ($name) ? $this->createElement( $name, $value, $properties ) : '';
	}
	
	protected function createLabel($name, $label)
	{
		$lb = new ElementXml( 'label' );
		$lb->for = $name;
		$lb->class = 'label-' . $name;
		$lb->addElement( $label );
		
		return $lb;
	}
	
	public function getElement()
	{
		return $this->element;
	}
	
	public function getType()
	{
		return $this->element->type;
	}
	
	public function getID()
	{
		return $this->element->id;
	}
	
	public function getName()
	{
		return $this->element->name;
	}
	
	public function getLabel()
	{
		return $this->label;
	}
	
	public function changeValue($value)
	{
		$this->element->value = $value;
	}
	
	abstract protected function createElement($name, $value, $properties);
}