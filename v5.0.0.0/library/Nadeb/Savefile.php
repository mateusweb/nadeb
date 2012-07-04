<?php
/**
 * Nadëb (Makú-Nadëb)
 *
 * @filesource 
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    Freeware
 * @package    Nadeb_Savefile
 * @subpackage Nadeb.savefile
 * @version    1.0
 */

class Nadeb_Savefile
{
	public static function save($_file,$_content,$_replace = false)
	{
		$name_file = $_file;
//		if( is_file($name_file) && $_replace == false ) $name_file = $_file . '.temp';
		
		$fp = fopen($name_file, 'w');
		fwrite($fp, $_content);
		fclose ($fp);
	}
	
	public static function get($_file)
	{
		$result = "";
		$handle = @fopen($_file, "r");
		if ($handle) {
		    while (!feof($handle)) {
		        $buffer  = fgets($handle, 4096);
		        $result .= $buffer;
		    }
		    fclose($handle);
		}
		
		return $result;
	}
}