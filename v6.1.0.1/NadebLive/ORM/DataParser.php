<?php

namespace NadebLive\ORM;

class DataParser
{
	public function dataGetField( $data, $field )
	{
		if( is_array( $field ) )
		{
			$method    = 'get' . ucfirst( key( $field ) );
			$subMethod = 'get' . ucfirst( $field[key( $field )] );
			$subItem   = $data->$method();
		}
		else
		{
			$method = 'get' . ucfirst( $field );
		}
		
		$string = is_array( $data )
					? $data[ $field ]
					: (is_array( $field )
							? isset( $subItem ) ? $subItem->$subMethod() : ''
							: $data->$method());
		
		return $string;
	}
}

