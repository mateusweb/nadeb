<?php 
include_once 'DataGrid/Component/ToolsComponent.php';

class DeleteTool extends ToolsComponent
{
	protected function setElementName()
	{
		$this->class = 'edit_excluir';
	}

	public function createLink($primaryValue)
	{
		$element = new ElementXml( 'td' );
		$element->class = $this->class;
		
		$a = new ElementXml( 'a' );
		$a->title = $this->label;
		$a->href = $this->action . '/id/' . $primaryValue;
		$a->addElement( $this->label );
		$element->addElement( $a );
		
		return $element->__toString();
	}

}
	