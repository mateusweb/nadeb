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
 * Class Nadeb_Loader_Html
 * Retorna como string um html carregado de um arquivo
 * 
 * @category   Nadeb
 * @package    Nadeb_Loader_Html
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 */
class Nadeb_Loader_Html
{
	/**
	 * 
	 * @var string
	 */
	private $patch;
	
	/**
	 * @var string
	 */
	private $result;
	
    /**
     * Carrega o html especificado e armazena em result
     *
	 * @param string $_file nome do arquivo html a ser carregado
     * @return void
	 */
	public function load($_file)
	{
		$file   = $this->patch . $_file . ".html";
 		$f      = fopen($file, "r");
 		$string = fread($f, filesize($file));
		
		$this->result = $string;
		
		return $this;
	}
	
	/**
	 * Define o caminho onde será carregados os arquivos
	 * 
	 * @param string $_patch
	 * @return void
	 */
	public function set_patch($_patch)
	{
		$this->patch = $_patch;
		
		return $this;
	}
	
	/**
	 * retorna a variavél result
	 * 
	 * @return string
	 */
	public function get_result()
	{
		return $this->result;
	}
}
