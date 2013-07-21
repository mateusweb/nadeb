<?php
namespace NadebLive;

/**
 * Nadëb (Makú-Nadëb)
 * 
 * @author     Mateus Martins <mateusweb@gmail.com>
 * @copyright  Copyright 2013 mateusweb.co
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 * @package    NadebLive
 * @version    1.0.1
 */


/**
 * Class ClearLinks
 * Remove spacial charters from links
 * 
 * @category   ClearLinks
 * @package    ClearLinks
 * @copyright  Copyright 2013 mateusweb.co
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 */
class ClearLinks
{
	public static function clear($link)
	{
		$link = ClearLinks::normaliza($link);
		$link = preg_replace('/ /', '-', $link);
		$link = preg_replace('/[^a-z0-9-]/','', $link);
		$link = preg_replace('/--+/','-', $link);
		$link = preg_replace('/-$/','', $link);
        
        return $link;
	}
	
	private static function normaliza($string)
	{
		$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ“”"\'';
		$b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr    ';
		
		$string = utf8_decode($string);    
		$string = strtr($string, utf8_decode($a), $b);
		$string = strtolower($string);
		
		return utf8_encode($string);
	}	
}