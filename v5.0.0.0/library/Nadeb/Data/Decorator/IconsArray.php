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
 * Class Nadeb_Data_Decorator_IconsArray
 * 
 * 
 * @category   Nadeb
 * @package    Nadeb_Data_Decorator_Grid
 * @copyright  Copyright 2011 mateusweb.com.br
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 */
class Nadeb_Data_Decorator_IconsArray
{
	public static function get($params = null)
	{
		$icon = $params['params']['matrix'][ $params['value'] ];
		$url  = $params['params']['url'] . '/id/' . $params['primary'];
		
		$html = '<a class="iconSwap" id="item'.$params['primary'].'" href="'.$url.'"><img width="24" height="24" alt="Adicionar" src="/public/admin/images/'.$icon.'"></a>';
		
		
		return $html;
	}
}
