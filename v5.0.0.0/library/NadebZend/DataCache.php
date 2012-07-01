<?php
/**
 * Nadëb (Makú-Nadëb)
 *
 * @filesource 
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    Freeware
 * @package    Nadeb_File_UploadFiles
 * @subpackage Nadeb.Grid.Sql
 * @version    1.0
 */

class NadebZend_DataCache
{
	private $frontendOptions;
	private $backendOptions;
	private $nameCache;
	private $cache;
	
	/**
	* @var object
	*/
	protected static $_instance = null;
	
	/**
	* Metodo Construtor
	*
	* @return void
	*/
	private function __construct()
	{
	}
	
	/**
	* Retorna a instancia de NadebZend_DataCache
	* Implementação do Singleton pattern
	*
	* @return NadebZend_DataCache
	*/
	public static function get_instance($nameCache = null)
	{
		if (null === self::$_instance)
		{
			self::$_instance = new self();
			
			self::$_instance->nameCache = $nameCache;
			self::$_instance->frontendOptions = array('automatic_serialization' => true);
			self::$_instance->backendOptions = array('cache_dir' => APPLICATION_PATH . '/cache/',
														'cache_db_complete_path' => APPLICATION_PATH . '/cache/data_cache.db');
			self::$_instance->makeZendCacheFactory();
		}
	
		
		return self::$_instance;
	}
	
	private function makeZendCacheFactory()
	{
		$this->cache = Zend_Cache::factory('Core','Sqlite',$this->frontendOptions,$this->backendOptions);
	}
	
	public function load()
	{
		return $this->cache->load( $this->nameCache );
	}
	
	public function remove()
	{
		$this->cache->remove( $this->nameCache );
	}
	
	public function save($data)
	{
		$this->cache->save( $data, $this->nameCache );
	}
	
}