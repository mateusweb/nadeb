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
 * Class Nadeb_Captcha
 * 
 * @category   Nadeb
 * @package    Nadeb_Captcha
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 */
class Nadeb_Captcha
{
    public $width;
    public $height;
    public $fontSize;
    public $letterSize;

	public function __construct()
	{
	}
	
    public function getImage()
    {
		header("Content-type: image/jpeg"); // define o tipo do arquivo
        
		$cPath =  '/library/Nadeb/Components/Captcha/';
    	
		$bg     = imagecreatefrompng( $_SERVER['DOCUMENT_ROOT'] . $cPath . 'fundo.png' );
		$crop   = imagecreatetruecolor( $this->width, $this->height );
		$white  = imagecolorallocate($crop, 255,255,255);
		
		imagecopyresized( 
			$crop, 
			$bg, 
			0, 0, 0, 0, 
			$this->width,
			$this->height, 
			$this->width, 
			$this->height
		);
		$imagem = $crop;
		
        $white  = imagecolorallocate($imagem,255,255,255);
        $font   = "arial.ttf";
        $font   = $cPath . 'fonte2.ttf';
        $word   = substr(str_shuffle("AaBbCcDdEeFfGgHhIiJjKkLlMmNnPpQqRrSsTtUuVvYyXxWwZz23456789"),0,($this->letterSize));
        
        $session = new Zend_Session_Namespace();
        $session->captcha = $word;
        
        for($i = 1; $i <= $this->letterSize; $i++)
        {
            imagettftext(
            	$imagem,
            	$this->fontSize,
            	rand(-25,25),
            	($this->fontSize*$i),
            	($this->fontSize + 10),
            	$white,
            	$font,
            	substr($word,($i-1),1)
            ); 
        }
        
        imagejpeg($imagem); 
        imagedestroy($imagem);
        
        die();
    }
   
	public function validateCaptcha()
	{
        $session = new Zend_Session_Namespace();
        return $session->captcha;
	}
   
	public function clearValueCaptcha()
	{
        $session = new Zend_Session_Namespace();
        $session->captcha = '';
	}
}