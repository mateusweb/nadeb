<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initDoctype()
	{
		$this->bootstrap('view');
		$view = $this->getResource('view');
		$view->doctype('HTML5');
	}
	
	protected function _initRouter()
	{
		$this->bootstrap('frontController');
		$config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini', 'routes');
		$router = $this->getResource('frontController')
						->getRouter()
						->addConfig($config, 'routes');
	
		return $router;
	}
	
	protected function _initFrontController()
	{
		$front = Zend_Controller_Front::getInstance();
		$front->setControllerDirectory(array
		(
			'site'	 => APPLICATION_PATH . '/modules/site/controllers/',
			'admin'	=> APPLICATION_PATH . '/modules/admin/controllers/',
		));
		$front->addModuleDirectory( APPLICATION_PATH . '/modules' );
		$front->setParam('useDefaultControllerAlways', true);
		$front->setDefaultModule( 'site' );
		$front->setDefaultControllerName( 'index' );
		$front->setDefaultAction( 'index' );
		
		return $front;
	}
	
	protected function _initMetadataCache()
	{
		$frontendOptions = array('automatic_serialization' => true);
		$backendOptions = array('cache_dir' => APPLICATION_PATH . '/cache/',
								'cache_db_complete_path' => APPLICATION_PATH . '/cache/entities_metadata.db');
		
		$cache = Zend_Cache::factory('Core','Sqlite',$frontendOptions,$backendOptions);
		Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);
	}
	
	protected function _initAutoloader()
	{
		set_include_path( get_include_path() . ';' . $_SERVER['DOCUMENT_ROOT'] . '/library/NadebLive');
		
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace("Nadeb");
		$autoloader->registerNamespace("NadebZend");
		unset($autoloader);
		
		new Zend_Application_Module_Autoloader(array(
			'namespace' => 'Site',
			'basePath' => APPLICATION_PATH . '/modules/site',
		));
		new Zend_Application_Module_Autoloader(array(
			'namespace' => 'Admin',
			'basePath' => APPLICATION_PATH . '/modules/admin',
		));
	}
}
	