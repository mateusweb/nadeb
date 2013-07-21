<?php 

namespace NadebLive\DataGrid\Helpers;

use NadebLive\DataGrid\Component\DataParser;

use NadebLive\Xml\ElementXml;
use NadebLive\DataGrid\Interfaces\DataGridHelperInterface;

class GArray extends DataParser implements DataGridHelperInterface
{
	private $data;
	private $field;
	private $primary;
	private $matrix;
	
	public function __construct(array $matrix)
	{
		$this->matrix = $matrix;
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
		return $this->matrix[ $this->dataGetField( $this->data, $this->field ) ];
	}
}