<?php

namespace NadebLive\DataGrid;

use NadebLive\Xml\ElementXml;
use NadebLive\DataGrid\Interfaces\DataGridInterface;
use NadebLive\DataGrid\Interfaces\DataGridHelperInterface;
use NadebLive\DataGrid\Helpers\GText;
use NadebLive\DataGrid\Helpers\GSwap;
use NadebLive\DataGrid\Helpers\GArray;

class GridBody implements DataGridInterface
{
	private $thead;

	public function __construct()
	{
		$this->thead = new ElementXml( 'tbody' );
	}

	public function setColumns($columns)
	{
		$dataGrid = DataGrid::getInstance();
		foreach ( $dataGrid->getData() as $id => $matrix )
		{
			$method = 'get' . ucfirst( $dataGrid->getPrimary() );
			$primaryValue = ( is_array( $matrix ) ) 
								? $matrix[ $dataGrid->getPrimary() ]
								: $matrix->$method();
			
			$tr = new ElementXml( 'tr' );
			$tr->addElement( $this->checkBox( $dataGrid, $primaryValue ) );

			foreach ( $columns as $key => $value )
			{
				$obj = !( $value instanceof DataGridHelperInterface ) ? new GText() : $value;
				$obj->setData( $matrix );
				$obj->setField( is_int( $key ) ? $value : $key );
				$obj->setPrimary( $dataGrid->getPrimary() );

				$td = new ElementXml( 'td' );
				$td->addElement( $obj->get() );
				$tr->addElement( $td );
			}
			$tr = $this->addTolls( $dataGrid, $tr, $primaryValue );
			$this->thead->addElement( $tr );
		}
	}

	private function addTolls(DataGrid $dataGrid, ElementXml $tr, $primaryValue)
	{
		$tools = $dataGrid->getTools();
		if( $tools )
		{
			foreach ( $tools as $obj )
			{
				$tr->addElement( $obj->createLink( $primaryValue ) );
			}
		}
		return $tr;
	}

	public function checkBox(DataGrid $dataGrid, $primaryValue)
	{
		if( $dataGrid )
		{
			$td = new ElementXml( 'td' );
			$td->class = 'td_checkbox';

			$input = new ElementXml( 'input' );
			$input->name = 'id[]';
			$input->type = 'checkbox';
			$input->value = $primaryValue;
			$td->addElement( $input );

			return $td;
		}
		return false;
	}

	public function get()
	{
		return $this->thead;
	}
}