<?php
/**
 * Nadëb (Makú-Nadëb)
 *
 * @filesource 
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    Freeware
 * @package    Nadeb_Controller
 * @subpackage Nadeb.Controller.Front
 * @version    2.0
 */
include_once 'HeaderController.php';
include_once 'JScontroller.php';

class NadebZend_Controller_Crud extends NadebZend_Controller_Auth 
{
	protected $__model;
	private $model;
	
	public function init()
	{
    	parent::init();

    	$header      = HeaderController::get_instance();
		$header->css = "library/NadebZend/Components/Template/css/reset.css";
		$header->css = "library/NadebZend/Components/Template/css/style.css";
		$header->js  = "library/NadebZend/Components/Javascript/jquery_plugins/jquery-min.js";
		$header->js  = "library/NadebZend/Components/Javascript/jquery_plugins/jquery-ui-1.8.2.custom.min.js";
    	
    	$js             = JScontroller::get_instance();
		$js->JSInstance = "admin";
		
		$controller = explode( '-', strtolower($this->_request->controller) );
		$ctrl = ucfirst($controller[0]);
		if( isset($controller[1]) ) $ctrl .= ucfirst($controller[1]);
		
		$model = (isset($this->__model)) ? $this->__model : "Admin_Model_" . $ctrl;
		
		$this->model = new $model;
		$this->model->_params = $this->_request;
		
		$links = new Admin_Model_Controllers();
		$dataLinks = $links->get_links();
		$this->view->menuLinks = $dataLinks['menu'];
		$this->view->sideBarlinks = $dataLinks['sideBar'];
	}
	
	public function listAction()
    {
    	$header      = HeaderController::get_instance();
		$header->css = "library/NadebZend/Components/Template/css/grid.css";
		$header->css = "library/NadebZend/Components/Template/css/forms.css";
		$header->js  = "library/Nadeb/Components/Javascript/jquery_plugins/jquery.form.js";
		
		$js             = JScontroller::get_instance();
		$js->JSInstance = "admin_grid";
		
    	$this->view->breadCrumb = $this->model->breadCrumbs(  $this->_getParam('action') );
    	$this->view->search = $this->model->search_form();
    	$this->view->html = $this->model->data_grid( $this->_getAllParams() );
    	$this->renderScript("nadeb/response.phtml");
    }

    public function editAction()
    {
		$js             = JScontroller::get_instance();
		$js->JSInstance = "admin_form";
		
    	$header      = HeaderController::get_instance();
		$header->css = "library/NadebZend/Components/Template/css/forms.css";
		$header->js  = "library/NadebZend/Components/Javascript/jquery_plugins/jquery.form.js";
		
    	$this->view->breadCrumb = $this->model->breadCrumbs(  $this->_getParam('action') );
    	$this->view->html = $this->model->data_form($this->_getParam('id'), $this->_request->getPost());
    	$this->renderScript("nadeb/response.phtml");
    }
    
    public function deleteAction()
    {
    	$this->view->html = $this->model->delete($this->_getParam('id'));
    	$this->renderScript("nadeb/response.phtml");
    }
    
	public function listFolderAction()
	{
		$this->view->html = $this->model->list_galery_json( $this->_getParam("folder") );
		
		$this->_helper->layout->disableLayout();
		$this->renderScript("nadeb/response.phtml");
	}
	
	public function addToFolderAction()
	{
		$this->view->html = $this->model->add_to_folder( $this->_getParam("folder") );
		$this->_helper->layout->disableLayout();
		$this->renderScript("nadeb/response.phtml");
	}
	
	public function delToFolderAction()
	{
		$this->view->html = $this->model->del_to_folder( $this->_request->getParams() );
		
		$this->_helper->layout->disableLayout();
		$this->renderScript("nadeb/response.phtml");
	}
	
	public function clearPictureAction()
	{
		$this->view->html = $this->model->clear_picture( $this->_request->getParams() );
		
		$this->_helper->layout->disableLayout();
		$this->renderScript("nadeb/response.phtml");
	}
	
	public function saveLegendAction()
	{
		$this->view->html = $this->model->save_galery_json( $this->_getParam("folder") );
		
		$this->_helper->layout->disableLayout();
		$this->renderScript("nadeb/response.phtml");
	}

	public function saveOrderAction()
	{
		$this->view->html = $this->model->save_order( $this->_getParam("neworder") );
		
		$this->_helper->layout->disableLayout();
		$this->renderScript("nadeb/response.phtml");
	}
	
	public function swapAction()
	{
		$this->view->response = $this->model->swap_active( $this->_getAllParams() );
		
		$this->_helper->layout->disableLayout();
		$this->renderScript("nadeb/response.phtml");
	}
	
	public function getModel()
	{
		return $this->model;
	}
}