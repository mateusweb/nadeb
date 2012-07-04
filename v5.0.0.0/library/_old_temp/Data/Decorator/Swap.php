<?php
/**
 * Nadëb (Makú-Nadëb)
 * 
 * @author     Mateus Martins <mateusweb@gmail.com>
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 * @package    Nadeb
 * @version    1.0.0
 */


/**
 * Class Nadeb_Data_Decorator_Swap
 * Monta um XHTML do tipo exibir e não exibir para chamar o metodo swapAction do Controlador Crud 
 * 
 * @category   Nadeb
 * @package    Nadeb_Data_Decorator_Swap
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 */
class Nadeb_Data_Decorator_Swap
{
    public static function get($params = null)
    {
		if( $params['value'] == "1")
		{
			$xhtml = str_replace("//","/","<a href='{$params['params']}/swap/key/{$params['column']}/id/{$params['primary']}' id='swap{$params['column']}{$params['primary']}' class='set_swap'><img src='/library/Nadeb/Components/TemplateBlue/images/set_1.gif' width='15' height='15' alt='Remover' /></a>");
		}
		else
		{
			$xhtml = str_replace("//","/","<a href='{$params['params']}/swap/key/{$params['column']}/id/{$params['primary']}' id='swap{$params['column']}{$params['primary']}' class='set_swap'><img src='/library/Nadeb/Components/TemplateBlue/images/set_0.gif' width='15' height='15' alt='Adicionar' /></a>");
		}
    	
    	return $xhtml;
    }
	
}
