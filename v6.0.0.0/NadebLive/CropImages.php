<?php
namespace NadebLive;

class CropImages
{
	private $patch;
	private $file;
	private $new_width = null;
	private $new_height = null;
	private $img;
	private $positX;
	private $positY;
	private $atual_width;
	private $atual_height;
	private $final_width;
	private $final_height;
	public $fixedTop;
		
	public function __construct()
	{
		$this->fixedTop  = false;
	}
	
	public function set_patch($_value)
	{
		$this->patch = $_value;
		
		return $this;
	}
	
	public function set_file($_value)
	{
		$this->file = $_value;
		
		return $this;
	}
	
	public function set_newName($_value)
	{
		$this->new_name = __ROOT__ . '/' . $this->patch . '/' . $_value;
		
		return $this;
	}
	
	public function set_newSize($_w = null, $_h = null)
	{
		$path = __ROOT__ . '/' . $this->patch .'/'. $this->file;
		$path = preg_replace('/\/\/+/','/',$path);
		$tmImg = getimagesize( $path );
		$_h = ($_h) ? $_h : round( ($tmImg[1] / $tmImg[0]) * $_w );
		
		$this->new_width  = $_w;
		$this->new_height = $_h;
		
		return $this;
	}
	
	public function create()
	{
	    $file = __ROOT__ . '/' . $this->patch . '/' . $this->file;
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

	public function crop_by_width()
	{
		$this->final_width  = $this->new_width;
		$this->final_height = $this->new_height;
		
		$this->new_width = floor( $this->atual_width * ( $this->new_height / $this->atual_height ) );
		
		$this->positY = ($this->fixedTop) ? 0 : ($this->final_width - $this->new_width) / 2;
		$this->positX = ($this->final_height - $this->new_height) / 2;
		
		return $this;
	}

	public function crop_by_height()
	{
		$this->final_width  = $this->new_width;
		$this->final_height = $this->new_height;
		
		$this->new_height = floor( $this->atual_height * ( $this->new_width / $this->atual_width ) );
		
		$this->positX = ($this->fixedTop) ? 0 : ($this->final_height - $this->new_height) / 2;
		$this->positY = ($this->final_width - $this->new_width) / 2;
		
		return $this;
	}

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