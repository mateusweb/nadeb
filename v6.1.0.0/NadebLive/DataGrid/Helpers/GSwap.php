<?php 

namespace NadebLive\DataGrid\Helpers;

use NadebLive\DataGrid\Component\DataParser;

use NadebLive\Xml\ElementXml;
use NadebLive\DataGrid\Interfaces\DataGridHelperInterface;

class GSwap extends DataParser implements DataGridHelperInterface
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
		$primaryValue = $this->dataGetField( $this->data, $this->primary );
		$text = $this->dataGetField( $this->data, $this->field );
				
		$a = new ElementXml( 'a' );
		$a->class = 'set-swap ' . ($text == $this->trueValue ? 'set1' : 'set0');
		$a->id = '{\true\ : \\' . $this->trueValue . '\, \false\ : \\' . $this->falseValue . '\, \field\ : \\'.$this->field.'\}';
		$a->href = preg_replace( '|(\/)+|', '/', $this->rootPath . '/' . $primaryValue  );

		$a->addElement( $text );
		
		return $a;
	}
}