<?php 
abstract class ToolsComponent
{
	protected $class;
	protected $action;
	protected $label;
	protected $name;
	
	public function __construct($label = '', $action = '', $name = null)
	{
		$this->name = $name;
		$this->label = $label;
		$this->action = $action;
		
		$this->setElementName();
	}
	
	abstract protected function setElementName();
	abstract public function createLink($primaryValue);
}