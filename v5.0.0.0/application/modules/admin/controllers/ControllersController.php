<?php
class Admin_ControllersController extends NadebZend_Controller_Crud
{
	public function init()
	{
    	parent::init();
    	
    	$auth = Zend_Auth::getInstance();
    	if( $auth->getStorage()->read()->groupName != 'Nadeb' )
			$this->_redirect('/admin/index/');
	}
}