<?php
class Admin_IndexController extends NadebZend_Controller_Crud
{
	protected $__model = 'Admin_Model_Login';
	
    public function init()
    {
    	parent::init();
    }
    
	public function indexAction()
	{
// 		$auth = Zend_Auth::getInstance();
// 		print_r( $auth->hasIdentity() );
	}
    
}

