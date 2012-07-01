<?php 
include_once 'DataGrid/Interfaces/DataGridHelperInterface.php';

class GSwap implements DataGridHelperInterface
{
	private $trueValue;
	private $falseValue;
	private $rootPath;
	private $data;
	private $field;
	private $primary;
	
	public function __construct($rootPath, $trueFalseValue)
	{
		$trueFalseValue = explode( ',', $trueFalseValue );
		
		$this->trueValue = $trueFalseValue[0];
		$this->falseValue = $trueFalseValue[1];
		$this->rootPath = $rootPath;
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
		$a = new ElementXml( 'a' );
		$a->class = 'set_swap';
		$a->id = "{$this->field}{$this->data[ $this->primary ]}";
		$a->href = "{$this->rootPath}/swap/key/{$this->field}/id/{$this->data[ $this->primary ]}/trueValue/{$this->trueValue}/falseValue/{$this->falseValue}";
		
		$img = new ElementXml( 'img' );
		$img->src = '/library/NadebZend/Components/Template/images/' . ($this->data[ $this->field ] == $this->trueValue ? 'set_1.gif' : 'set_0.gif' );
		$img->width = '15';
		$img->height = '15';
		$img->alt = 'Remover';
		
		$a->addElement( $img );
		
		return $a;
	}
}