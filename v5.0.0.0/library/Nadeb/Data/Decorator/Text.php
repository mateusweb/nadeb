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
class Nadeb_Data_Decorator_Text
{
	public static function get($params = null)
	{
		return $params['value'];
	}
}
