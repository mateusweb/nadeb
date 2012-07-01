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
 * Class Nadeb_Folder
 * Lista diretorios/sub-diretorios/arquivos
 * 
 * @category   Nadeb
 * @package    Nadeb_Folder
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 */
class Nadeb_Folder
{
	private $result;
	
	public function list_folders_recursive($_pasta, $level = 0)
	{
		$folder = "";
		$pasta  = $_SERVER["DOCUMENT_ROOT"] . $_pasta;
		
		$this->result['folders'][$level++] = $_pasta;
		
		if(is_dir($pasta)) 
		{
			$dir = dir($pasta);
			$dir->rewind();
			
			while($folders=$dir->read())
			{
				if ($folders != "." && $folders != ".."  && $folders != ".svn")
				{
					if( !is_dir("$pasta/$folders") )
					{
						$this->result['files'][$_pasta][] = $folders;
					}
					else
					{
						$this->list_folders_recursive($_pasta . $folders . "/", $level++);
					}
				}
			}
		}
	}
	
	public function move_files_recursive($_origem,$_destino)
	{
		$this->list_folders_recursive( $_origem );
		foreach($this->result['folders'] as $key => $value)
		{
			$patch = str_replace($_origem,$_destino,$value);
			@mkdir($_SERVER["DOCUMENT_ROOT"] . $patch, 0777,true);
			@chmod($_SERVER["DOCUMENT_ROOT"] . $patch, 0777,true);
		}
		
		foreach($this->result['files'] as $folder => $array)
		{
			foreach($array as $key => $value)
			{
				$origem  = $_SERVER["DOCUMENT_ROOT"] . $folder . $value;
				$destino = str_replace($_origem,$_destino,$origem);
				@copy($origem,$destino);
			}
		}
		
	}
	
	public function listFolders($pasta)
	{
		$folder = "";
		$pasta  = $_SERVER["DOCUMENT_ROOT"] . $pasta;
		if(is_dir($pasta)) 
		{
			$dir = dir($pasta);
			$dir->rewind();
			$folders = $dir->read();
			
			while($folders=$dir->read())
			{
				if ($folders != "." && $folders != ".."  && $folders != ".svn")
				{
					if(is_dir("$pasta/$folders")) $folder[] = $folders;
				}
			}
		}
		
		return $folder;
	}
	
	public function listFiles($pasta)
	{
		$files = "";
		$pasta = $_SERVER["DOCUMENT_ROOT"] . $pasta;
		
		if(is_dir($pasta)) 
		{
			$dir = dir($pasta);
			$dir->rewind();
			$folders = $dir->read();
			
			while($folders=$dir->read())
			{
				if(!is_dir("$pasta/$folders")) 
					if( !strpos($folders,".db"))
						$files[] = $folders;
			}
		}
		
		return $files;
	}
	
	public function get_list()
	{
		return $this->result;
	}
}
?>