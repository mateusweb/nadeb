<?php 

namespace NadebLive\DataGrid;

use NadebLive\Xml\ElementXml;
use NadebLive\DataGrid\Interfaces\DataGridInterface;

class GridHeader implements DataGridInterface
{
	private $thead;
	
	public function __construct()
	{
		$this->thead = new ElementXml( 'thead' );
	}
	
	public function setColumns($columns)
	{
		$dataGrid = DataGrid::getInstance();
		$this->thead->addElement( $this->buttons( $dataGrid ) );
		
		$tr = new ElementXml( 'tr' );
		$tr->addElement( $dataGrid->checkAll() );
		
		foreach ( $columns as $key => $value)
		{
			$th = new ElementXml( 'th' );
			if( !is_int( $key ) ) $th->class = $value;
			is_int( $key ) ? $th->addElement( $value ) : $th->addElement( $key );
			
			$tr->addElement( $th );
		}
		
		if( $dataGrid->getTools() )
		{
			$th = new ElementXml( 'th' );
			$th->colspan = count( $dataGrid->getTools() );
			$th->class = 'th_editar';
			$th->addElement( 'Tools' );
			
			$tr->addElement( $th );
		}
		
		
		$this->thead->addElement( $tr );
	}
	
	private function buttons(DataGrid $dataGrid)
	{
		$tr = new ElementXml( 'tr' );
		$tr->class = "buttons";
		
		$th = new ElementXml( 'th' );
		$th->colspan = 99;
		
		$th->addElement( '' );
		$controllers = $dataGrid->getControllers();
		if( $controllers )
			foreach ( $controllers as $obj )
				$th->addElement( $obj );
		
		$tr->addElement( $th );
		
		return $tr; 
	}
	
	public function get()
	{
		return $this->thead;
	}
}