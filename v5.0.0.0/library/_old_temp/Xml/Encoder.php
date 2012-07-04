<?php
class Nadeb_Xml_Encoder
{

	/**
	 * @var object
	 */
	protected static $_instance = null;
	
	private $xml = '';
	
	/**
	 * Metodo Construtor
	 * 
	 * @return void
	 */
	private function __construct()
	{
	}
	
    /**
     * Retorna a instancia de Nadeb_Xml_Encoder
     * Implementação do Singleton pattern 
     *
     * @return Nadeb_Xml_Encoder
     */
    public static function get_instance()
    {
        if (null === self::$_instance)
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
    
	public static function get($array)
	{
		$XML = Nadeb_Xml_Encoder::get_instance();
		$XML->encode( $array, 'item' );
		
		return $XML->getXML();
	}
	
	public function encode($array, $nodeName)
	{
		if( is_int( $nodeName ) ) $nodeName = 'item';
		
		foreach($array as $name => $value)
		{
			if( is_array($value) )
			{
				$this->xml .= "<$nodeName>";
				$this->encode($value, $name);
				$this->xml .= "</$nodeName>";
			}
			else
				$this->xml .= "<$name><![CDATA[$value]]></$name>";
		}
	}
	
	public function getXML()
	{
		return $this->xml;
	}
}