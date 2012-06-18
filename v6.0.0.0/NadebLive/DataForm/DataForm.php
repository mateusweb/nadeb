<?php
namespace NadebLive\DataForm;

use NadebLive\DataForm\Component\DataFormComponent;
use NadebLive\Xml\ElementXml;
use NadebLive\DataForm\InputText;
use NadebLive\DataForm\InputPassword;
use NadebLive\DataForm\InputSubmit;

//include_once 'Select.php';
//include_once 'InputText.php';
//include_once 'TextArea.php';
//include_once 'JSEditor.php';
//include_once 'InputFile.php';
//include_once 'RadioButton.php';
//include_once 'Checkbox.php';
//include_once 'InputHidden.php';
//include_once 'InputPassword.php';
//include_once 'JSFolder.php';
//include_once 'InputSubmit.php';
//include_once 'InputButton.php';

class DataForm
{
	private $dl;
	private $fieldset;
	private $element;
	private $title;
	private $data;
	private $jsFolder;
	private $elementMap;

	public function __construct($name)
	{
		$this->title = null;
		$this->jsFolder = null;

		$this->dl = new ElementXml( 'dl' );
		$this->dl->class = 'dl-' . $name;

		$this->fieldset = new ElementXml( 'fieldset' );
		$this->fieldset->class = 'fieldset-' . $name;
		$this->fieldset->addElement( $this->dl );

		$this->element = new ElementXml( 'form' );
		$this->element->id = $name;
		$this->element->class = $name;
		$this->element->action = '#';
		$this->element->name = $name;
		$this->element->method = 'post';
		$this->element->enctype = 'multipart/form-data';
		$this->element->addElement( $this->fieldset );
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
		$this->dl->addElement( $this->crateDT(  $element ) );
		$this->dl->addElement( $this->crateDD(  $element ) );

		$this->elementMap[$element->getId()] = $element->getType();
	}

	public function jsFolder(JSFolder $element)
	{
		$this->dl->addElement( $this->crateDD(  $element ) );
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
		$this->dl = new ElementXml( 'dl' );
		$this->dl->class = 'dl-' . $name;

		$this->fieldset = new ElementXml( 'fieldset' );
		$this->fieldset->class = 'fieldset-' . $name;
		$this->fieldset->addElement( $this->dl );

		$this->element->addElement( $this->fieldset );
	}

	public function label($name, $value)
	{
		$label = new ElementXml( 'label' );
		$label->class = 'label-' . $name;
		$label->addElement( $value );

		$dt = new ElementXml( 'dt' );
		$dt->class = 'dt-' . $name;
		$dt->addElement( $label );

		$this->dl->addElement( $dt );
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

		$this->dl->addElement( $dd );
	}

	public function form()
	{
		return $this->element;
	}

	public function get()
	{
		return $this->title . $this->element . $this->jsFolder;
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
			if( $value != 'InputSubmit' && $value != 'InputButton' && $value != 'JSFolder' && $value != 'InputFile' && isset( $post[$key] ) )
			{
				$data[$key] = !is_array( $post[ $key ] ) ? $post[ $key ] : implode( ',',$post[ $key ] ) ;
			}
		}

		return $data;
	}

	private function crateDT(DataFormComponent $element)
	{
		if( isset( $this->data[ $element->getID() ] ) ) $obj = $element->changeValue( $this->data[ $element->getID() ] );
		if( $element->getLabel() )
		{
			$dt = new ElementXml( 'dt' );
			$dt->id = $element->getID() . '-label';
			$dt->class = $element->getID() . '-label';
			$dt->addElement( $element->getLabel() );

			return $dt;
		}

		return false;
	}

	private function crateDD(DataFormComponent $element)
	{
		if( isset( $this->data[ $element->getID() ] ) ) $obj = $element->changeValue( $this->data[ $element->getID() ] );
		if( $element->getElement() )
		{
			$dd = new ElementXml( 'dd' );
			$dd->id = $element->getID() . '-object';
			$dd->class = $element->getID() . '-object';
			$dd->addElement( $element->getElement() );

			return $dd;
		}

		return $element;
	}
}
