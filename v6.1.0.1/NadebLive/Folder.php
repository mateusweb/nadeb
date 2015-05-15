<?php
namespace NadebLive;

class Folder
{
	public function listFolders($pasta)
	{
		$folder = "";
		$pasta = preg_replace( '|(\/)+|', '/', $pasta );

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
		$pasta = preg_replace( '|(\/)+|', '/', $pasta );

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