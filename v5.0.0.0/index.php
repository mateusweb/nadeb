<?php
/**
 * Seta o timezone para a região definida
 */
date_default_timezone_set('America/Sao_Paulo');

// Define root path
define('__ROOT__', '/');

// Define root path to links
define('__LINKS__', '/');

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/application'));

// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'localhost'));

// Ensure library/ is on include_path
set_include_path(
	implode(
		PATH_SEPARATOR, 
		array(
			realpath(APPLICATION_PATH . '/../library'),
			realpath(APPLICATION_PATH . '/modules'),
	    	get_include_path()
		)
	)
);

//die( APPLICATION_ENV );

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();

