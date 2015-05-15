<?php
namespace NadebLive\DataForm;

use NadebLive\DataForm\Component\DataFormComponent;
use NadebLive\Xml\ElementXml;

class DataForm
{
	private $components;
	private $element;
	private $title;
	private $data;
	private $jsFolder;
	private $elementMap;
	private $outerHtml;

	public function __construct($name)
	{
		$this->title = null;
		$this->jsFolder = null;

		$this->components = new ElementXml( 'fieldset' );
		$this->components->class = 'fieldset-' . $name;

		$this->element = new ElementXml( 'form' );
		$this->element->id = $name;
		$this->element->class = $name . ' form-horizontal';
		$this->element->action = '#';
		$this->element->name = $name;
		$this->element->method = 'post';
		$this->element->enctype = 'multipart/form-data';
		$this->element->addElement( $this->components );
	}

	public function setData( array $data = null )
	{
		$this->data = $data;
	}

	public function setAction( $action )
	{
		$this->element->action = preg_replace('|(\/)+|', '/', $action);
	}

	public function add(DataFormComponent $element)
	{
		$div = new ElementXml( 'div' );
		$div->id = $element->getID() . '-object';
		$div->class = 'control-group';
		$div->addElement( $this->crateLabel(  $element ) );
		$div->addElement( $this->crateDiv(  $element ) );

		$this->components->addElement( $div );
		$this->elementMap[$element->getId()] = $element->getType();
	}

	public function jsFolder(JSFolder $element)
	{
		$this->components->addElement( $this->crateDiv(  $element ) );
		$this->jsFolder = $element->folderComponent( $element );

		$this->elementMap[$element->getId()] = $element->getType();
	}

	public function title($text)
	{
		$this->title = new ElementXml( 'h2' );
		$this->title->class = 'session-title';
		$this->title->addElement( $text );
	}

	public function fieldset($name)
	{
		$this->components = new ElementXml( 'fieldset' );
		$this->components->class = 'fieldset-' . $name;

		$this->element->addElement( $this->components );
	}

	public function label($name, $value)
	{
		$label = new ElementXml( 'label' );
		$label->class = 'label-' . $name;
		$label->addElement( $value );

		$dt = new ElementXml( 'dt' );
		$dt->class = 'dt-' . $name;
		$dt->addElement( $label );

		$this->components->addElement( $dt );
	}

	public function link($name, $value, $href)
	{
		$a = new ElementXml( 'a' );
		$a->href = $href;
		$a->class = $name;
		$a->addElement( $value );

		$dd = new ElementXml( 'dd' );
		$dd->class = 'dd-' . $name;
		$dd->addElement( $a );

		$this->components->addElement( $dd );
	}

	public function outerHtml($html)
	{
		$this->outerHtml = $html;
	}

	public function form()
	{
		return $this->element;
	}

	public function get()
	{
		return $this->title . $this->element . $this->jsFolder . $this->outerHtml;
	}

	public function getElementMap()
	{
		return $this->elementMap;
	}

	public function getDataToInsert($post, $file)
	{
        
		foreach( $this->elementMap as $key => $value )
		{
			$value = str_replace("NadebLive\\DataForm\\", "", $value);

			if( $value == 'InputFile' && isset( $file[ $key ][ 'name' ] ) )
			{
				$data[$key] = $file[ $key ][ 'name' ];
			}
			if( $value != 'InputSubmit' && $value != 'InputButton' && $value != 'InputFile' && isset( $post[$key] ) )
			{
				$data[$key] = !is_array( $post[ $key ] ) ? $post[ $key ] : implode( ',',$post[ $key ] ) ;
			}
		}
        
		return $data;
	}

	private function crateLabel(DataFormComponent $element)
	{
		if( isset( $this->data[ $element->getID() ] ) ) $obj = $element->changeValue( $this->data[ $element->getID() ] );
		if( $element->getLabel() )
		{
			$label = $element->getLabel();
			$label->class = 'control-label';

			return $label;
		}

		return false;
	}

	private function crateDiv(DataFormComponent $element)
	{
		if( isset( $this->data[ $element->getID() ] ) ) $obj = $element->changeValue( $this->data[ $element->getID() ] );
		if( $element->getElement() )
		{
			$div = new ElementXml( 'div' );
// 			$div->id = $element->getID() . '-object';
			$div->class = 'controls';
			$div->addElement( $element->getElement() );

			return $div;
		}

		return $element;
	}
	
	public function createImageLink($imagePath)
	{
		$showImage = null;
		if( $imagePath )
		{
			$showImage = new ElementXml( 'a' );
			$showImage->class = 'lightbox linkRed';
			$showImage->href = $imagePath;
			$showImage->addElement( '[ver imagem]' );
		}
	
		return $showImage;
	}
}
