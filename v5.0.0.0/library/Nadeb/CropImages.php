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
 * Class Nadeb_Login
 * Redimenciona imagens
 * 
 * @category   Nadeb
 * @package    Nadeb_CropImages
 * @copyright  Copyright 2010 mateusweb.com.br
 * @license    http://www.gnu.org/licenses/gpl.html | GPL
 */
class Nadeb_CropImages
{
	/**
	 * @var string
	 */
	private $patch;
	
	/**
	 * @var string
	 */
	private $file;
	
	/**
	 * @var int
	 */
	private $new_width = null;
	
	/**
	 * @var int
	 */
	private $new_height = null;
	
	/**
	 * @var resource an image
	 */
	private $img;
	
	private $positX;
	private $positY;
	private $atual_width;
	private $atual_height;
	private $final_width;
	private $final_height;
	public $fixedTop;
		
	/**
	 * Metodo construtor
	 * 
	 * @return void
	 */
	public function __construct()
	{
		$this->fixedTop  = false;
	}
	
    /**
     * Seta o caminho da imagem 
     *
     * @return Nadeb_CropImages
     */
	public function set_patch($_value)
	{
		$this->patch = $_value;
		
		return $this;
	}
	
    /**
     * Seta o nome da imagem 
     *
     * @return Nadeb_CropImages
     */
	public function set_file($_value)
	{
		$this->file = $_value;
		
		return $this;
	}
	
    /**
     * Seta o nome da imagem 
     *
     * @return Nadeb_CropImages
     */
	public function set_newName($_value)
	{
		
		$this->new_name = $_SERVER["DOCUMENT_ROOT"] . $this->patch . '/' . $_value;
		
		return $this;
	}
	
	
    /**
     * Seta o nome da imagem 
     *
     * @return Nadeb_CropImages
     */
	public function set_newSize($_w = null, $_h = null)
	{
		$path = $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . $this->patch .'/'. $this->file;
		$path = preg_replace('/\/\/+/','/',$path);
		$tmImg = getimagesize( $path );
		$_h = ($_h) ? $_h : round( ($tmImg[1] / $tmImg[0]) * $_w );
		
		$this->new_width  = $_w;
		$this->new_height = $_h;
		
		return $this;
	}
	
	/**
	 * Cria uma instancia de imagem para a classe manipular
	 * 
	 *  @return Nadeb_CropImages
	 */
	public function create()
	{
	    $file = $_SERVER["DOCUMENT_ROOT"] . $this->patch . '/' . $this->file;
	    if( is_file($file) )
	    {
	    	if( stripos( $file,"gif" ) )
			{
				$this->img = @imagecreatefromgif( $file );
			}
			elseif( stripos( $file,"png" ) )
			{
				$this->img = @imagecreatefrompng( $file );
			}
			elseif( stripos( $file,"jpg" ) )
			{
				$this->img = @imagecreatefromjpeg( $file );
			}
	    	elseif( stripos( $file,"jpeg" ) )
			{
				$this->img = @imagecreatefromjpeg( $file );
			}
			else
			{
				$this->img = @imagecreatefromgif("http://dummyimage.com/1x1");
			}
	    }
	    else
	    {
//	    	$this->img = imagecreatefromgif("http://dummyimage.com/" . $this->new_width . "x" . $this->new_height);
	    	$this->img = @imagecreatefromgif("http://dummyimage.com/1x1");
	    }
	    
		$this->atual_width  = @imagesx( $this->img );
		$this->atual_height = @imagesy( $this->img );
	    
		$this->final_width  = $this->new_width;
		$this->final_height = $this->new_height;
		
		return $this;
	    
	}

	/**
	 * 
	 * 
	 *  @return Nadeb_CropImages
	 */
	public function crop_by_width()
	{
		$this->final_width  = $this->new_width;
		$this->final_height = $this->new_height;
		
		$this->new_width = floor( $this->atual_width * ( $this->new_height / $this->atual_height ) );
		
		$this->positY = ($this->fixedTop) ? 0 : ($this->final_width - $this->new_width) / 2;
		$this->positX = ($this->final_height - $this->new_height) / 2;
		
		return $this;
	}

	/**
	 * 
	 * 
	 *  @return Nadeb_CropImages
	 */
	public function crop_by_height()
	{
		$this->final_width  = $this->new_width;
		$this->final_height = $this->new_height;
		
		$this->new_height = floor( $this->atual_height * ( $this->new_width / $this->atual_width ) );
		
		$this->positX = ($this->fixedTop) ? 0 : ($this->final_height - $this->new_height) / 2;
		$this->positY = ($this->final_width - $this->new_width) / 2;
		
		return $this;
	}

	/**
	 * 
	 * 
	 *  @return Nadeb_CropImages
	 */
	public function auto_crop()
	{
		if($this->atual_width < $this->atual_height)
		{
			$this->crop_by_height();
		}
		
		if($this->atual_width > $this->atual_height)
		{
			$this->crop_by_width();
		}
		
		if($this->atual_width == $this->atual_height)
		{
			$this->new_width   = $this->final_width;
			$this->new_height  = $this->final_height;
			
			$this->positY =($this->fixedTop) ? 0 : ($this->final_width - $this->new_width) / 2;
			$this->positX = ($this->final_height - $this->new_height) / 2;
		}
		
		return $this;
	}

	/**
	 * 
	 * 
	 *  @return Nadeb_CropImages
	 */
	public function make_file()
	{
		$tmp_img = imagecreatetruecolor( $this->final_width,$this->final_height );
		$white   = imagecolorallocate($tmp_img, 220, 230, 240);
		
		imagefilledrectangle($tmp_img, 0, 0, $this->final_width, $this->final_height, $white);
		@imagecopyresized( 
			$tmp_img, 
			$this->img, 
			$this->positY, $this->positX, 0, 0, 
			$this->new_width,
			$this->new_height, 
			$this->atual_width, 
			$this->atual_height
		);
				
		imagepng($tmp_img, $this->new_name);
		imagedestroy($tmp_img);
	}
	
}