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
 * Class Nadeb_GlobalValidates
 * 
 * @category   Nadeb
 * @package    Nadeb_GlobalValidates
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 */
class Nadeb_GlobalValidates
{
	/**
	 * Verifica se um e-mail é válido
	 * 
	 * @param string $email
	 * @return boolean
	 */
	public static function isEmail($email)
	{
		if( !preg_match( '/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i', $email ) )
		{
			return false;
		}
		
		return true;
	}
	
	/**
	 * Verifica se um cpf é válido
	 * 
	 * @param string $cpf
	 * @return boolean
	 */
	public static function isCPF($cpf)
	{
		if( preg_match("/^(\d{3}\.){2}\d{3}-\d{2}$/",$cpf) || preg_match("/\d{11}$/",$cpf) )
	    {
	        $cpf = preg_replace("/[.-]/","",$cpf);
	        if(substr_count($cpf,substr($cpf,0,1)) >= 11)
	        {
	            return false;
	        }
	        else
	        {
	            $cpf_temp = substr($cpf,0,9);
	            $soma1 = 0;
	            $soma2 = 0;
	            for($i = 1; $i<= 9; $i++)
	            {
	                $soma1 += intval(substr($cpf,$i-1,1)) * $i;
	            }
	            $dv1 = $soma1 % 11;
	            if($dv1 == 10) { $dv1 = 0; }
	            $cpf_temp = $cpf_temp.$dv1;
	            for($i = 0; $i<=9;$i++)
	            {
	                $soma2 += intval(substr($cpf_temp,$i,1)) * $i;
	            }
	            $dv2 = $soma2 % 11;
	            if($dv2 == 10) { $dv2 = 0; }
	            $cpf_final = $cpf_temp.$dv2;
	            if(strcmp($cpf,$cpf_final))
	            {
	                return false;
	            }
	        }      
	    }
	    else
	    {
	        return false;
	    }
	    
	    return true;
	}

	/**
	 * Verifica se um cnpj é válido
	 * 
	 * @param string $_value
	 * @return boolean
	 */
	public static function isCNPJ($_value)
	{
		if (strlen($_value) <> 14)
			return false;

		$soma  = 0;
		$soma += ( $_value[0]  * 5 );
		$soma += ( $_value[1]  * 4 );
		$soma += ( $_value[2]  * 3 );
		$soma += ( $_value[3]  * 2 );
		$soma += ( $_value[4]  * 9 );
		$soma += ( $_value[5]  * 8 );
		$soma += ( $_value[6]  * 7 );
		$soma += ( $_value[7]  * 6 );
		$soma += ( $_value[8]  * 5 );
		$soma += ( $_value[9]  * 4 );
		$soma += ( $_value[10] * 3 );
		$soma += ( $_value[11] * 2 );
		$d1 = $soma % 11;
		$d1 = $d1 < 2 ? 0 : 11 - $d1;
		
		$soma  = 0;
		$soma += ( $_value[0]  * 6 );
		$soma += ( $_value[1]  * 5 );
		$soma += ( $_value[2]  * 4 );
		$soma += ( $_value[3]  * 3 );
		$soma += ( $_value[4]  * 2 );
		$soma += ( $_value[5]  * 9 );
		$soma += ( $_value[6]  * 8 );
		$soma += ( $_value[7]  * 7 );
		$soma += ( $_value[8]  * 6 );
		$soma += ( $_value[9]  * 5 );
		$soma += ( $_value[10] * 4 );
		$soma += ( $_value[11] * 3 );
		$soma += ( $_value[12] * 2 );
		$d2 = $soma % 11;
		$d2 = $d2 < 2 ? 0 : 11 - $d2;
		
		if ($_value[12] == $d1 && $_value[13] == $d2)
			return true;
		else
			return false;
	}
}