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
 * Class Nadeb_ClearLinks
 * Remove acentos e caracteres especiais dos links
 * 
 * @category   Nadeb
 * @package    Nadeb_ClearLinks
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 */
class Nadeb_ClearLinks
{
	public static function clear($link)
	{
		$link = Nadeb_ClearLinks::normaliza($link);
		$link = preg_replace('/ /', '-', $link);
		$link = preg_replace('/[^a-z0-9-]/','', $link);
		$link = preg_replace('/--+/','-', $link);
		$link = preg_replace('/-$/','', $link);
        
        return $link;
	}
	
	public static function normaliza($string)
	{
		$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ“”"\'';
		$b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr    ';
		
		$string = utf8_decode($string);    
		$string = strtr($string, utf8_decode($a), $b);
		$string = strtolower($string);
		
		return utf8_encode($string);
	}	
}