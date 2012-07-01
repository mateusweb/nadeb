<?php
include_once '/DataForm/DataForm.php';
include_once '/DataGrid/Form/FormSearch.php';
include_once '/DataGrid/DataGrid.php';
include_once '/HeaderController.php';
include_once '/JScontroller.php';

class Admin_Model_Login extends NadebZend_Model_Crud
{
	public function __construct()
	{
    	$header      = HeaderController::get_instance();
		$header->css = "library/NadebZend/Components/Template/css/reset.css";
		$header->css = "library/NadebZend/Components/Template/css/style.css";
		
    	$this->tb = new Application_Model_Db_Users();
    	
    	parent::__construct();
	}
	
	public function data_form_login()
	{
    	$header      = HeaderController::get_instance();
		$header->css = "library/NadebZend/Components/Template/css/forms.css";
		$header->css = "library/NadebZend/Components/Template/css/login.css";
		
		$form = new DataForm( 'login' );
		$form->form()->action = __LINKS__ . 'admin/login/sigin/';
		$form->add( new InputText('email','E-mail') );
		$form->add( new InputPassword('password','Senha') );
		$form->add( new InputSubmit('btn_login', 'Entrar') );
		
		return $form->get();
	}
	
	public function validate($usr, $psw)
	{
    	$filter = new Zend_Filter_StripTags();
		$auth = new Nadeb_ZendAuth_Adapter($filter->filter( $usr ), $filter->filter( $psw ));
		$result = $auth->authenticate();
		
		$auth = Zend_Auth::getInstance();
		$cache = NadebZend_DataCache::get_instance( 'adminMenuGrupo' . $auth->getStorage()->read()->idGroup );
		$cache->remove();
	}
	
	public function sign_out()
	{
		$auth = new Nadeb_ZendAuth_Adapter();
		$auth->unAuthenticate();
	}
	
}


















