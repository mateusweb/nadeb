<?php
class Application_Model_Db_Users extends Zend_Db_Table_Abstract
{
	protected $_name = "users";
	protected $_primary = "idUser";
	protected $_dependentTables = array("Application_Model_Db_Groups");
	
}

