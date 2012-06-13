<?php 

namespace NadebLive\DataGrid\Tools;

use NadebLive\Xml\ElementXml;
use NadebLive\DataGrid\Component\ToolsComponent;

class MoveTool extends ToolsComponent
{
	protected function setElementName()
	{
		$this->class = 'edit_move';
	}

	public function createLink($primaryValue)
	{
		$element = new ElementXml( 'td' );
		$element->class = $this->class;
		
		$a = new ElementXml( 'a' );
		$a->title = $this->label;
		$a->href = $this->action . '/move/' . $primaryValue;
		$a->addElement( $this->label );
		$element->addElement( $a );
		
		return $element->__toString();
	}

}
