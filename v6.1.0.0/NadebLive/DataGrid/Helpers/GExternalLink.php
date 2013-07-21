<?php 

namespace NadebLive\DataGrid\Helpers;

use NadebLive\DataGrid\Component\DataParser;

use NadebLive\DataGrid\Interfaces\DataGridHelperInterface;
use NadebLive\Xml\ElementXml;

class GExternalLink extends DataParser implements DataGridHelperInterface
{
	private $data;
	private $field;
	private $primary;
	private $start;
	private $end;
	
	public function __construct($start = null, $end = null)
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
		
		$a = new ElementXml( 'a' );
		$a->href = $text;
		$a->target = 'blank';
		
		$value = isset( $this->start ) && isset( $this->end )
			? substr( $text, $this->start, $this->end ) . '...'
			: $text;
		
		$a->addElement( $value );
		
		return $a;
	}
}