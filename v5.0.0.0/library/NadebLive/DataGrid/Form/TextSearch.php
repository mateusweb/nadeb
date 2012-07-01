<?php 
include_once 'DataGrid/Component/SearchFormComponent.php';

class TextSearch extends SearchFormComponent
{
	protected function createElement($name, $value, $properties)
	{
		$element = new ElementXml( 'input' );
		$element->type = 'text';
		$element->id = $name;
		$element->class = 'inputSearch';
		$element->name = $name;
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
}
