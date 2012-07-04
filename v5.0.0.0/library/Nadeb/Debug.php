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
 * Class Nadeb_Debug
 * Inrerrompe  a execução e escreve um parametro passado
 * 
 * @category   Nadeb
 * @package    Nadeb_Debug
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 */
class Nadeb_Debug
{
    /**
     * Set the default autoloader implementation
     *
	 * @param all $_param
     * @return void
	 */
	public static function x($_param)
	{
		echo ( "<pre>" );
		print_r ( $_param );
		echo ( "</pre>" );
		exit;
	}
}
