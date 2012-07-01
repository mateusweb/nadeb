<?php
class Admin_LoginController extends NadebZend_Controller_Front
{
    public function init()
    {
    	parent::init();
    }
    
	public function indexAction()
	{
		$login = new Admin_Model_Login();
		
		$this->view->form = $login->data_form_login();
	}
    
	public function siginAction()
	{
		if( $this->getRequest()->getParam('email') && $this->getRequest()->getParam('password') )
		{
			$login = new Admin_Model_Login();
			$login->validate(
				$this->getRequest()->getParam('email'), 
				$this->getRequest()->getParam('password')
			);
		}
		$this->_redirect('/admin/');
	}
    
	public function signOutAction()
	{
		$login = new Admin_Model_Login();
		$login->sign_out();
		
		$this->_redirect('/admin/');
	}
}

