<?php
namespace NadebLive\DataForm\Component;

use NadebLive\DataForm\Interfaces\FormElementInterface;

abstract class DataFormComponent implements FormElementInterface
{
	protected $name;
	protected $element;
	protected $label;
	protected $properties;

	public function __construct($name = '', $label = '', $value = '', array $properties = null)
	{
		$this->name = null;
		$this->label = null;
		$this->element = null;
		$this->properties = $properties;

		$this->label = ($label) ? $this->createLabel( $name, $label ) : '';
		$this->element = ($name) ? $this->createElement( $name, $value, $properties ) : '';
	}

	public function getElement()
	{
		return $this->element;
	}

	public function getID()
	{
		return $this->element->id;
	}

	public function getType()
	{
		return get_class($this);
	}

	public function getName()
	{
		return $this->name;
	}

	public function getLabel()
	{
		return $this->label;
	}

	public function changeValue($value)
	{
		$this->element->value = $value;
	}

	abstract protected function createLabel($name, $value);
	abstract protected function createElement($name, $value, $properties);
}