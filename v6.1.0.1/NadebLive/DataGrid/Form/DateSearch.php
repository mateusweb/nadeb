<?php 
include_once 'DataGrid/Component/SearchFormComponent.php';

class DateSearch extends SearchFormComponent
{
	protected function createElement($name, $value, $properties)
	{
		$element = new ElementXml( 'input' );
		$element->type = 'text';
		$element->id = 'start_date';
		$element->class = 'start_date';
		$element->name = 'start_date';
		if($properties) foreach ($properties as $key => $val) $element->$key = $val;
		
		$element2 = new ElementXml( 'input' );
		$element2->type = 'text';
		$element2->id = 'end_date';
		$element2->class = 'end_date';
		$element2->name = 'end_date';
		if($properties) foreach ($properties as $key => $val) $element2->$key = $val;
		
		
		$dt = $this->crateDT( $element );
		$dd = $this->crateDD( $element, $element2 );
		
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
	
	protected function crateDD(ElementXml $element1, ElementXml $element2)
	{
		$dd = new ElementXml( 'dd' );
		$dd->id = $element1->id . 'Param';
		$dd->class = $element1->id . '-object';
		$dd->addElement( $element1 . $element2 );
	
		return $dd;
	}
}
