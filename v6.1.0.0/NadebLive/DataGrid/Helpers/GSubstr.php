<?php 

namespace NadebLive\DataGrid\Helpers;

use NadebLive\ORM\DataParser;

use NadebLive\DataGrid\Interfaces\DataGridHelperInterface;
use NadebLive\Xml\ElementXml;

class GSubstr extends DataParser implements DataGridHelperInterface
{
	private $data;
	private $field;
	private $primary;
	private $start;
	private $end;
	
	public function __construct($start = 0, $end = 50)
	{
		$this->start = $start;
		$this->end = $end;
	}
	
	public function setData($data)
	{
		$this->data = $data;
	}
	
	public function setField($field)
	{
		$this->field = $field;
	}
	
	public function setPrimary($value)
	{
		$this->primary = $value;
	}
	
	public function get()
	{
		$text = $this->dataGetField( $this->data, $this->field );
		
		return substr( $text, $this->start, $this->end ) . '...';
	}
}