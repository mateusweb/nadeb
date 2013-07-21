<?php 

namespace NadebLive\DataGrid\Helpers;

use NadebLive\DataGrid\Component\DataParser;

use NadebLive\Xml\ElementXml;
use NadebLive\DataGrid\Interfaces\DataGridHelperInterface;

class GText extends DataParser implements DataGridHelperInterface
{
	private $data;
	private $field;
	private $primary;
	
	public function __construct()
	{
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
		return $this->dataGetField( $this->data, $this->field );
	}
}