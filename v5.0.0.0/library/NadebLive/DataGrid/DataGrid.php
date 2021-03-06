<?php 
include_once 'Xml/ElementXml.php';
include_once 'DataGrid/Interfaces/DataGridInterface.php';
include_once 'DataGrid/GridHeader.php';
include_once 'DataGrid/GridBody.php';
include_once 'DataGrid/GridFooter.php';
include_once 'Controllers/DeleteButton.php';
include_once 'Controllers/Link.php';
include_once 'Tools/MoveTool.php';
include_once 'Tools/EditTool.php';
include_once 'Tools/DeleteTool.php';
include_once 'Tools/LinkTool.php';

class DataGrid
{
	private $header;
	private $body;
	private $footer;
	private $grid;
	private $form;
	private $readOnly;
	private $data;
	private $title;
	private $tools;
	private $primary;
	private $controllers;
	private static $instance;
	
	public function __construct($name)
	{
		self::$instance = $this;
		
		$this->title = null;
		$this->tools = null;
		$this->controllers = null;
		$this->header = null;
		$this->body = null;
		$this->footer = null;
		$this->form = null;
		$this->readOnly = false;
		$this->grid = new ElementXml( 'table' );
		$this->grid->class = $name;
	}
	
	public static function getInstance()
	{
		return self::$instance;
	}
	
	public function setData(array $data = null)
	{
		$this->data = $data;
	}
	
	public function title($text)
	{
		$this->title = new ElementXml( 'h2' );
		$this->title->class = 'session-title';
		$this->title->addElement( $text );
	}
	
	public function primary($value)
	{
		$this->primary = $value;
	}
	
	public function setHeader(array $columns)
	{
		$this->header = new GridHeader();
		$this->header->setColumns( $columns );
		
		$this->setFooter( $columns );
	}
	
	public function setRows(array $rows)
	{
		$this->body = new GridBody();
		$this->body->setColumns( $rows );
	}
	
	public function setFooter(array $columns)
	{
		$this->footer = new GridFooter();
		$this->footer->setColumns( $columns );
	}
	
	public function setAction( $action )
	{
		$this->form = new ElementXml( 'form' );
		$this->form->id = 'fGrid';
		$this->form->action = $action;
	}
	
	public function setControllers($obj)
	{
		$this->controllers[] = $obj; 
	}
	
	public function getControllers()
	{
		return $this->controllers; 
	}
	
	public function setTools(ToolsComponent $obj)
	{
		$this->tools[] = $obj; 
	}
	
	public function getTools()
	{
		return $this->tools; 
	}
	
	public function readOnly($param)
	{
		$this->readOnly = $param;
	}
	
	public function checkAll()
	{
		if( !$this->readOnly )
		{
			$th = new ElementXml( 'th' );
			$th->class = 'td_checkbox';
			
			$a = new ElementXml( 'a' );
			$a->href = 'todos';
			$a->addElement( 'all' );
			$th->addElement( $a );
			
			return $th;
		}
		
		return false;
	}
	
	public function getData()
	{
		return $this->data;
	}
	
	public function getPrimary()
	{
		return $this->primary;
	}
	
	public function get()
	{
		if( $this->header ) $this->grid->addElement( $this->header->get() );
		if( $this->footer ) $this->grid->addElement( $this->footer->get() );
		if( $this->body ) $this->grid->addElement( $this->body->get() );
		if( $this->form ) $this->form->addElement( $this->grid );
		$grid = $this->form ? $this->form : $this->grid;
		
		return  $this->title . $grid;
	}
}
