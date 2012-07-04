<?php
/**
 * Nadëb (Makú-Nadëb)
 *
 * @filesource 
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    Freeware
 * @package    Nadeb_Controller
 * @subpackage Nadeb.Controller.Xml
 * @version    2.0
 */

class Nadeb_Controller_Xml extends Zend_Controller_Action 
{
	public function init()
	{
		$this->_helper->layout->setLayout( 'xml' );
	}
}