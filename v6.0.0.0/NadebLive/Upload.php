<?php
namespace NadebLive;

class Upload
{
	public function sendFiles( array $map )
	{
		$result = $_FILES;
		foreach ($result as $key => $value)
		{
			$path    = $this->getFolder( $map, $key );
			$newName = $this->hashName( $value['name'] );
			$tmpName = $value["tmp_name"];

			if( move_uploaded_file($tmpName, $path . $newName) )
			{
				$result[$key]['name'] = $newName;
				if( is_file($path . $newName) ) chmod( $path . $newName , 0777 );
			}

			if( !$result[$key]['name'] ) unset( $result[$key] );


		}

		return $result;
	}

	private function hashName( $name )
	{
		$ar_name = explode(".",$name);
		$ext = strtolower(".".$ar_name[count($ar_name)-1]);

		$rnd_name = md5( date('YmdHis') . rand(1000000000001, 9999999999999) );
	    $new_name = $rnd_name.$ext;

	    return $new_name;
	}

	private function getFolder( $map, $key )
	{
		$path = $_SERVER['DOCUMENT_ROOT'] .'/'. ( isset( $map[$key]['path'] ) ? $map[$key]['path'] : $map['default']['path'] ) . '/';
		$path = preg_replace( '|(\/)+|', '/', $path );

		if( !is_dir( $path ) ) mkdir( $path, 0777, true );
		if(  is_dir( $path ) ) chmod( $path, 0777 );

		return $path;
	}
}