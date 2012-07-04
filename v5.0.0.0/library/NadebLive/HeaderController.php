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
 * Class HeaderController
 * Gerencia os includes (js|css) do header
 * 
 * @category   Nadeb
 * @package    Nadeb_JScontroller
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 */
class HeaderController
{
	/**
	 * @var object
	 */
	protected static $_instance = null;
	
	/**
	 * @var array
	 */
	public $header;
	
	/**
	 * Metodo Construtor
	 * 
	 * @return void
	 */
	private function __construct()
	{
	}
	
    /**
     * Retorna a instancia de Nadeb_HeaderController
     * Implementação do Singleton pattern 
     *
     * @return Nadeb_HeaderController
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
		$this->header[$_name][__ROOT__ . $_param] = null;
	}

	public function __get($_param = null)
	{
        return $this->header;
    }
	
	public function load()
	{
		$Headers = HeaderController::get_instance();

		$header = "";
		if( isset($Headers->header['css']) )
		{
			foreach( $Headers->css['css'] as $key => $value)
			{
				$header .= '<link href="'. $key .'" media="screen" rel="stylesheet" type="text/css" />' . "\n\t";
			}
		}
		
		if( isset($Headers->header['js']) )
		{
			foreach( $Headers->header['js'] as $key => $value)
			{
				$header .= '<script src="'. $key .'" type="text/javascript"></script>' . "\n\t";
			}
		}
		
		return ($header) ? $header : false;
	}
}
