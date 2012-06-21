<?php 

namespace NadebLive\DataGrid\Helpers;

use NadebLive\Xml\ElementXml;
use NadebLive\DataGrid\Interfaces\DataGridHelperInterface;

class GArray implements DataGridHelperInterface
{
	private $data;
	private $field;
	private $primary;
	private $matrix;
	
	public function __construct(array $matrix)
	{
		$this->matrix = $matrix;
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
		return $this->matrix[ $this->data[ $this->field ] ];
	}
}