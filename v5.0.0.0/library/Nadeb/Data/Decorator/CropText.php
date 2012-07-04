<?php
/**
 * Nadëb (Makú-Nadëb)
 * 
 * @author     Mateus Martins <mateusweb@gmail.com>
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 * @package    Nadeb
 * @version    2.0.0
 */


/**
 * Class Nadeb_Data_Decorator_Text
 * 
 * 
 * @category   Nadeb
 * @package    Nadeb_Data_Decorator_Grid
 * @copyright  Copyright 2011 mateusweb.com.br
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 */
class Nadeb_Data_Decorator_CropText
{
	public static function get($params = null)
	{
		$text = substr($params['value'],0,$params['params']);
		$text = stripslashes($text);
		$end  = strripos($text, ' ');
		$text = substr($text, 0, $end) . '...';
		
		return $text;
	}
}
