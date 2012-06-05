<?php 
include_once 'Component/DataFormComponent.php';
include_once 'HeaderController.php';
include_once 'JScontroller.php';

class JSEditor extends DataFormComponent
{
	protected function createElement($name, $value, $properties)
	{
		$this->name = $name;
		$this->properties = $properties;
		
		$header      = HeaderController::get_instance();
		$header->js  = "library/NadebZend/Components/Javascript/CLEditor/jquery.cleditor.min.js";
		$header->js  = "library/NadebZend/Components/Javascript/CLEditor/jquery.cleditor.xhtml.min.js";
		$header->css = "library/NadebZend/Components/Javascript/CLEditor/jquery.cleditor.css";
		
		$js             = JScontroller::get_instance();
		$js->JSInstance = "admin_JSEditor";
		
		$element = new ElementXml( 'textarea' );
		$element->id = $name;
		$element->class = $name . ' jsEditor';
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

	
