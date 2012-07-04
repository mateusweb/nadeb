<?php
class ElementXml
{
	private $attribute;
	private $child;
	private $name;
	
	public function __construct($name)
	{
		$this->attribute = array();
		$this->child = array();
		$this->name = $name;
	}
	
	public function __toString()
	{
		$str = '<' . $this->name;
		
		foreach ( $this->attribute as $name => $value )
		{
			$str .= ' ' . $name . '="' . $value . '"';
		}
		
		if( count( $this->child ) >= 1 )
		{
			$str .= '>';
			
			foreach ( $this->child as $child )
			{
				$str .= $child;
			}
			
			$str .= '</' . $this->name . '>';
		}
		else
		{
			$str .= '/>';
		}
		
		return $str;
	}
	
	public function addElement( $element )
	{
		$this->child[] = $element;
	}
	
	public function __set( $name, $value )
	{
		$this->attribute[ $name ] = $value;
	}
	
	public function __get( $name )
	{
		return $this->attribute[ $name ];
	}
}