<?php
namespace NadebLive\DataForm;

use NadebLive\DataForm\Component\DataFormComponent;
use NadebLive\Xml\ElementXml;

class JSFolder extends DataFormComponent
{
	public function __construct($name = '', $label = '', array $properties = null)
	{
		$value = md5( date("YmdHis") . rand(1000000000001, 9999999999999) );
		$this->label = null;
		$this->element = null;
		$this->properties = $properties;

		$this->label = ($label) ? $label : '';
		$this->element = ($name) ? $this->createElement( $name, $value, $properties ) : '';
	}

	protected function createElement($name, $value, $properties)
	{
		$this->name = $name;

		$element = new ElementXml( 'input' );
		$element->type = 'hidden';
		$element->id = $name;
		$element->class = $name;
		$element->name = $name;
		$element->value = $value;
		if($properties) foreach ($properties as $key => $val) $element->$key = $val;

		return $element;
	}

	protected function createLabel($name, $label)
	{
		return false;
	}

	public function folderComponent(JSFolder $element)
	{
		$header      = HeaderController::get_instance();
		$header->js  = "library/NadebZend/Components/Javascript/jquery_plugins/swfobject.js";

		$js = JScontroller::get_instance();
		$js->JSInstance = "admin_lightbox";
		$js->JSInstance = "admin_JSFolder";

		$h1 = new ElementXml('h1');
		$h1->addElement($element->getLabel());

		$flashBrowser = new ElementXml('span');
		$flashBrowser->id = 'flashBrowser';
		$flashBrowser->addElement( ' ' );

		$rootPath = new ElementXml('div');
		$rootPath->id = 'root_path';
		$rootPath->class = __ROOT__;
		$rootPath->addElement( '' );

		$formJsfolder = new ElementXml('form');
		$formJsfolder->id = 'formJsfolder';
		$formJsfolder->action = '#';
		$formJsfolder->addElement( $h1 . $flashBrowser . $rootPath );

		$jsfolder = new ElementXml('div');
		$jsfolder->id = 'jsfolder';
		$jsfolder->class = $element->getName();
		$jsfolder->addElement( $formJsfolder );

		return $jsfolder;
	}
}
