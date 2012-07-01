<?php 
include_once 'Xml/ElementXml.php';
include_once 'DataGrid/Form/DateSearch.php';
include_once 'DataGrid/Form/SelectSearch.php';
include_once 'DataGrid/Form/TextSearch.php';

class FormSearch
{
	private $dl;
	private $fieldset;
	private $element;

	public function __construct($name)
	{
		$header      = HeaderController::get_instance();
		$header->css = "library/NadebZend/Components/Javascript/ui_theme/jquery-ui-1.8.2.custom.css";
		$header->js  = "library/NadebZend/Components/Javascript/jquery_plugins/jquery-ui-1.8.2.custom.min.js";
		
		$js             = JScontroller::get_instance();
		$js->JSInstance = "admin_search";
		
		
		$this->dl = new ElementXml( 'dl' );
		$this->dl->class = 'dl-' . $name;
		
		$this->fieldset = new ElementXml( 'fieldset' );
		$this->fieldset->class = 'fieldset-' . $name;
		$this->fieldset->addElement( $this->dl );
		
		$this->element = new ElementXml( 'form' );
		$this->element->id = $name;
		$this->element->class = $name;
		$this->element->action = '#';
		$this->element->name = $name;
		$this->element->method = 'post';
		$this->element->addElement( $this->fieldset );
	}
	
	public function add(SearchFormComponent $element)
	{
		$this->dl->addElement( $element->getElement() );
	}
	
	public function form()
	{
		return $this->element; 
	} 
	
	public function get()
	{
		return $this->element;
	}
}
