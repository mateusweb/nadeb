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

class Nadeb_Controller_Front extends Zend_Controller_Action 
{
	public function init()
	{
		$this->_helper->layout->setLayout( $this->_getParam('module') );
		
		if( $this->_getParam('ajax') == true ) $this->_helper->layout->disableLayout();
		
		$session = $this->_getAllParams();
    	$this->view->controller = $this->_getParam('controller');
    	$this->view->action     = $this->_getParam('action');
    	$this->view->module     = $this->_getParam('module');
    	
    	
    	$this->view->title       = '';
    	$this->view->description = '';
    	$this->view->keywords    = '';
    	
    	if( is_file( APPLICATION_PATH . '/configs/SEO.ini' ) && $this->view->module != 'admin')
    	{
	    	$seo = new Zend_Config_Ini(APPLICATION_PATH . '/configs/SEO.ini', $this->_getParam('module'));
	    	$matrix = $seo->toArray();
    		$metaTitle = 
    			(isset($matrix[ $this->view->controller ][ $this->view->action ]['title']) 
    				? $matrix[ $this->view->controller ][ $this->view->action ]['title']
    				: (isset($matrix[ $this->view->controller ]['title'])
    					? $matrix[ $this->view->controller ]['title']
    					: (isset($matrix['inicial']['title'])
    						? $matrix['inicial']['title']
    						: '')));

    		$metaDescription = 
    			(isset($matrix[ $this->view->controller ][ $this->view->action ]['description']) 
    				? $matrix[ $this->view->controller ][ $this->view->action ]['description']
    				: (isset($matrix[ $this->view->controller ]['description'])
    					? $matrix[ $this->view->controller ]['description']
    					: (isset($matrix['inicial']['description'])
    						? $matrix['inicial']['description']
    						: '')));

    		$metaKeywords = 
    			(isset($matrix[ $this->view->controller ][ $this->view->action ]['keywords']) 
    				? $matrix[ $this->view->controller ][ $this->view->action ]['keywords']
    				: (isset($matrix[ $this->view->controller ]['keywords'])
    					? $matrix[ $this->view->controller ]['keywords']
    					: (isset($matrix['inicial']['keywords'])
    						? $matrix['inicial']['keywords']
    						: '')));
	    	
	    	$this->view->title       = $metaTitle;
    		$this->view->description = $metaDescription;
    		$this->view->keywords    = $metaKeywords;
    	}
	}
}