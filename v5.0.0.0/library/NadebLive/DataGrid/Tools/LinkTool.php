<?php 
include_once 'DataGrid/Component/ToolsComponent.php';

class LinkTool extends ToolsComponent
{
	protected function setElementName()
	{
		$this->class = $this->name ? $this->name : 'no-name';
	}

	public function createLink($primaryValue)
	{
		$element = new ElementXml( 'td' );
		$element->class = $this->class;
		
		$a = new ElementXml( 'a' );
		$a->title = $this->label;
		$a->href = $this->action . '/' . $primaryValue;
		$a->addElement( $this->label );
		$element->addElement( $a );
		
		return $element->__toString();
	}

}
