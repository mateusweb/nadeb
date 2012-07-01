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
 * Class Nadeb_String
 * Manipula dados e retorna string
 * 
 * @category   Nadeb
 * @package    Nadeb_JScontroller
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 */
class Nadeb_JScontroller
{
	/**
	 * @var object
	 */
	protected static $_instance = null;
	
	/**
	 * @var array
	 */
	public $JSInstances;
	
	/**
	 * Metodo Construtor
	 * 
	 * @return void
	 */
	private function __construct()
	{
	}
	
    /**
     * Retorna a instancia de Nadeb_JScontroller
     * Implementação do Singleton pattern 
     *
     * @return Nadeb_JScontroller
     */
    public static function get_instance()
    {
        if (null === self::$_instance)
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
	
	
	public function __set($_name,$_param)
	{
		$this->JSInstances['global'][$_param . '_global'] = $_param . '.global';
		$this->JSInstances['local'][$_param] = $_param;
	}

	public function __get($_param = null)
	{
        return $this->JSInstances;
    }
	
	public function load()
	{
		$JSInstances = Nadeb_JScontroller::get_instance();
		
		if( $JSInstances->JSInstances )
		{
			$JSLoad = new Nadeb_Loader_Javascript();
			$JSLoad->set_patch('library/Nadeb/Components/Javascript/');
			
			$jsGlobal = "";
			foreach( $JSInstances->JSInstances['global'] as $key => $value)
			{
				$jsGlobal .= $JSLoad->load( $value )->get_result();
			}
			
			$jsGlobal = str_replace("__ROOT__",__ROOT__,$jsGlobal);
			$jsGlobal = str_replace("\r\n","",$jsGlobal);
			$jsGlobal = str_replace("\t","",$jsGlobal);
			
			//////////////////////////
			
			$jsLocal = "";
			foreach( $JSInstances->JSInstances['local'] as $key => $value)
			{
				$jsLocal .= $JSLoad->load( $value )->get_result();
			}
			
			$jsLocal = str_replace("__ROOT__",__ROOT__,$jsLocal);
			$jsLocal = str_replace("\r\n","",$jsLocal);
			$jsLocal = str_replace("\t","",$jsLocal);
			
			$javaScript = '<script type="text/javascript">/* <![CDATA[ */ '.$jsGlobal.' $(document).ready(function(){'.$jsLocal.'}); /* ]]> */</script>';
			
			return $javaScript;
		}
		
		return false;
	}
}
