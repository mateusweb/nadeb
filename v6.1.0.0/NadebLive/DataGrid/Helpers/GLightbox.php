<?php 

namespace NadebLive\DataGrid\Helpers;

use NadebLive\DataGrid\Component\DataParser;

use NadebLive\DataGrid\Interfaces\DataGridHelperInterface;
use NadebLive\Xml\ElementXml;

class GLightbox extends DataParser implements DataGridHelperInterface
{
	private $data;
	private $field;
	private $primary;
	private $path;
	
	public function __construct($path)
	{
		$this->path = $path;
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
		$a = new ElementXml( 'a' );
		$a->class = 'nadeb-light-box';
		$a->href = ($this->path ? $this->path . '/' : '') . $this->dataGetField( $this->data, $this->field );

		$i = new ElementXml( 'i' );
		$i->class = 'icon-zoom-in';
		$i->addElement( ' ' );
		
		$a->addElement( $i . ' image zoom' );
		
		return $a;
	}
}