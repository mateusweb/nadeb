<?php
class Application_Model_Db_Controllers extends Zend_Db_Table_Abstract
{
	protected $_name = "controllers";
	protected $_primary = "idController";
	protected $_dependentTables = array("Application_Model_Db_Actions");
}

