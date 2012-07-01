<?php
/**
 * Nadëb (Makú-Nadëb)
 *
 * @filesource 
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    Freeware
 * @package    Nadeb_File_UploadFiles
 * @subpackage Nadeb.Grid.Sql
 * @version    1.0
 */

class Nadeb_Upload
{
	public function zend_upload($_path)
	{
		$path = str_replace('//','/',$_SERVER['DOCUMENT_ROOT'] . $_path);
		
		$upload = new Zend_File_Transfer_Adapter_Http();
		$upload->setDestination( $path )
				->addValidator('Count', false, 200)
				->receive();
		
		$result = $upload->getFileInfo();
		foreach ($result as $key => $value)
		{
			if(!$value['error'])
			{
				$newName = $this->hash_name($value['name']);
				$result[$key]['name'] = $newName;
				$result[$key]['tmp_name'] = $path . $newName;
				
				rename($value['tmp_name'], $path . $newName);
				if( is_file($path . $newName) ) chmod( $path . $newName , 0777 );
			}
		}
		
		return $result;
	}
	
	private function hash_name($name)
	{
		$ar_name = explode(".",$name);
		$ext = strtolower(".".$ar_name[count($ar_name)-1]);
		
		$date = new Zend_Date();
		$rnd_name = md5( $date->get('dMYHms') . rand(1000000000001, 9999999999999) );
	    $new_name = $rnd_name.$ext;
	
	    return $new_name;
	}
}