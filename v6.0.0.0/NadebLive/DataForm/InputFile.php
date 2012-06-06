<?php
namespace NadebLive\DataForm;

use NadebLive\DataForm\Component\DataFormComponent;
use NadebLive\Xml\ElementXml;

class InputFile extends DataFormComponent
{
	private $imagePath;
	private $removePath;

	public function __construct($name = '', $label = '', $value = '', array $properties = null, $imagePath = null, $removePath = null)
	{
		$this->label = null;
		$this->element = null;
		$this->properties = $properties;
		$this->imagePath = $imagePath;
		$this->removePath = $removePath;

		$this->label = ($label) ? $this->createLabel( $name, $label ) : '';
		$this->element = ($name) ? $this->createElement( $name, $value, $properties ) : '';
	}

	public function changeValue($value)
	{
		$showImage = null;
		$removePath = null;

		if( $this->imagePath )
		{
			$js = Nadeb_JScontroller::get_instance();
			$js->JSInstance = "admin_lightbox";

			$showImage = new ElementXml( 'a' );
			$showImage->class = 'lightbox linkRed';
			$showImage->href = $this->imagePath . '/' . $value;
			$showImage->addElement( '[ver imagem]' );
		}

		if( $this->removePath )
		{
			$removePath = new ElementXml( 'a' );
			$removePath->class = 'clearFolder linkRed';
			$removePath->href = $this->removePath;
			$removePath->addElement( '[x]' );
		}

		if( $this->imagePath || $this->removePath)
		{
			$this->label = $this->createLabel( $this->getName() ,  $this->getLabel() ) . ' ' . $showImage . ' ' . $removePath;
		}
	}

	protected function createElement($name, $value, $properties)
	{
		$this->name = $name;

		$element = new ElementXml( 'input' );
		$element->type = 'file';
		$element->id = $name;
		$element->class = $name;
		$element->name = $name;
		$element->value = $value;
		if($properties) foreach ($properties as $key => $val) $element->$key = $val;

		return $element;
	}

	protected function createLabel($name, $label)
	{
		$lb = new ElementXml( 'label' );
		$lb->for = $name;
		$lb->class = 'label-' . $name;
		$lb->addElement( $label );

		return $lb;
	}
}
