<?php
namespace NadebLive;

class File
{
	public function save( $file, $content )
	{
		$nameFile = $file;

		$fp = fopen($nameFile, 'w');
		fwrite($fp, $content);
		fclose ($fp);
	}

	public function get( $file )
	{
		$result = "";
		$handle = @fopen($file, "r");

		if( $handle )
		{
		    while( !feof( $handle ) )
			{
		        $buffer  = fgets( $handle, 4096 );
		        $result .= $buffer;
		    }
		    fclose( $handle );
		}

		return $result;
	}
}