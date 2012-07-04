<?php
/**
 * Nadëb (Makú-Nadëb)
 *
 * @filesource 
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    Freeware
 * @package    Nadeb_Controller
 * @subpackage Nadeb.Controller.Auth
 * @version    2.0
 */

class Nadeb_Controller_Auth extends Nadeb_Controller_Front
{
	protected $__model;
	
	public function init()
	{
		$auth    = Zend_Auth::getInstance();
		$storage = $auth->getStorage();
		$control = new Admin_Model_Controllers();
		
		if( !$auth->hasIdentity() && $this->_getParam('action') != 'add-to-folder' )
			$this->_redirect('/admin/login/');
		
		
		if( $this->_getParam('controller') != 'index' && $this->_getParam('action') != 'add-to-folder' && !$control->check_controllPermission($this->_getParam('controller'), $storage->read()->controllers) )
			$this->_redirect('/admin/');
			
			
    	parent::init();
	}
	
	
}