<?php

namespace NadebLive\DataGrid\Tools;

use NadebLive\Xml\ElementXml;
use NadebLive\DataGrid\Component\ToolsComponent;

class EditTool extends ToolsComponent
{
	protected function setElementName()
	{
		$this->class = 'edit_editar';
	}

	public function createLink($primaryValue)
	{
		$element = new ElementXml( 'td' );
		$element->class = $this->class;

		$a = new ElementXml( 'a' );
		$a->title = $this->label;
		$a->class = 'label label-success';
		$a->href = preg_replace('|(\/)+|', '/', $this->action . '/' . $primaryValue);
		$a->addElement( $this->label );
		$element->addElement( $a );

		return $element->__toString();
	}

}