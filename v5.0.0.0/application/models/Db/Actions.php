<?php
class Application_Model_Db_Actions extends Zend_Db_Table_Abstract
{
	protected $_name = "actions";
	protected $_primary = "idAction";
	protected $_referenceMap = array(
		"Controllers" => array(
			"columns" => "idController",
			"refTableClass" => "Application_Model_Db_Controllers",
			"refColumns" => "idController"
		)
	);
}

