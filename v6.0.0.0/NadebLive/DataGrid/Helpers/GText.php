<?php 

namespace NadebLive\DataGrid\Helpers;

use NadebLive\Xml\ElementXml;
use NadebLive\DataGrid\Interfaces\DataGridHelperInterface;

class GText implements DataGridHelperInterface
{
	private $data;
	private $field;
	private $primary;
	
	public function __construct()
	{
	}
	
	public function setData(array $data)
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
		return $this->data[ $this->field ];
	}
}