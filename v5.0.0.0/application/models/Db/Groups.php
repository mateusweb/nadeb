<?php
class Application_Model_Db_Groups extends Zend_Db_Table_Abstract
{
	protected $_name = "groups";
	protected $_primary = "idGroup";
	protected $_referenceMap = array(
		"Users" => array(
			"columns" => "idGroup",
			"refTableClass" => "Application_Model_Db_Users",
			"refColumns" => "idGroup"
		)
	);
	
}

