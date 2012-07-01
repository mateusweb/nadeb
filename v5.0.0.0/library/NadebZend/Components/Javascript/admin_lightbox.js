$('.lightbox').live("click",function(){
	var imgSr  = "";
	var imgSrc = $(this).attr('href');
	var img    = new Image();
	
	$('body').append('<div class="ltBox_bg"></div>');
	$('body').append('<div class="ltBox_window"><div class="barra">Fechar</div>');
	$('body').append('<div class="ltBox_container"></div>');

	$('.ltBox_window .barra').live('click',function(){
		/*
		$('.ltBox_bg').fadeTo('slow',0,function(){$('.ltBox_bg').remove()});
		$('.ltBox_window').fadeTo('fast',0,function(){$('.ltBox_window').remove()});
		$('.ltBox_container').fadeTo('fast',0,function(){$('.ltBox_container').remove()});
		*/
		$('.ltBox_bg').remove();
		$('.ltBox_window').remove();
		$('.ltBox_container').remove();
	});
	
	$('.ltBox_bg').fadeTo(0,0);
	$('.ltBox_window').fadeTo(0,0);
	
	$('.ltBox_bg').css('background-color','#000');
	$('.ltBox_bg').css('position','fixed');
	$('.ltBox_bg').css('height','100%');
	$('.ltBox_bg').css('width','100%');
	$('.ltBox_bg').css('left','0');
	$('.ltBox_bg').css('top','0');

	$('.ltBox_window').css('background','#fff url(http://nadeb-lightbox.googlecode.com/svn/trunk/img/loading.gif) center no-repeat');
	$('.ltBox_window').css('position','fixed');
	$('.ltBox_window').css('height','150px');
	$('.ltBox_window').css('width','150px');

	$('.ltBox_window .barra').css('font','14px Verdana,Helvetica,sans-serif');
	$('.ltBox_window .barra').css('padding-bottom','10px');
	$('.ltBox_window .barra').css('padding-top','10px');
	$('.ltBox_window .barra').css('padding-right','10px');
	$('.ltBox_window .barra').css('float','right');
	$('.ltBox_window .barra').css('cursor','pointer');
	
	$('.ltBox_container').css('position','fixed');
	
	$('.ltBox_window').css('left', ( $('.ltBox_bg').width() - $('.ltBox_window').width() ) / 2 );
	$('.ltBox_window').css('top', ( $('.ltBox_bg').height() - $('.ltBox_window').height() ) / 2 );
	
	$('.ltBox_bg').fadeTo('fast',0.5, function()
	{
		$('.ltBox_window').fadeTo('slow',1, function()
		{
			$(img).load(function () 
			{
				var imgWidth   = this.width;
			    var imgHeight  = this.height;
				var sobraA     = 0;
				var sobraB     = 0;
				
				$('.ltBox_container').css('left', ( $('.ltBox_bg').width() - (imgWidth) ) / 2);
				$('.ltBox_container').css('top', ( $('.ltBox_bg').height() - (imgHeight - 25) ) / 2);
				
				if( $('.ltBox_bg').width() < imgWidth )
				{
					imgWidth = $('.ltBox_bg').width() - 60;
					$('.ltBox_container').css('left', ( $('.ltBox_bg').width() - (imgWidth) ) / 2);
					$('.ltBox_container').css('width', imgWidth);
					$('.ltBox_container').css('overflow', 'auto');
				}
				if( $('.ltBox_bg').height() < imgHeight )
				{
					imgHeight = $('.ltBox_bg').height() - 70;
					$('.ltBox_container').css('top', ( $('.ltBox_bg').height() - (imgHeight -25) ) / 2);
					$('.ltBox_container').css('height', imgHeight);
					$('.ltBox_container').css('overflow', 'auto');
					
				}
				
				if( $('.ltBox_bg').height() < this.height && $('.ltBox_bg').width() > this.width )
				{
					sobraA = 20;
					$('.ltBox_container').css('width', imgWidth + 22);
				}
				
				if( $('.ltBox_bg').height() > this.height && $('.ltBox_bg').width() < this.width )
				{
					sobraB = 20;
					$('.ltBox_container').css('height', imgHeight + 22);
				}
			    
				$('.ltBox_window').animate({
					width : imgWidth + 20 + sobraA,
					height: imgHeight + 40 + sobraB,
					left  : ( $('.ltBox_bg').width() - (imgWidth + 20) ) / 2,
					top   : ( $('.ltBox_bg').height() - (imgHeight + 40) ) / 2
				},{
					duration: 500, 
					complete: function() {
						setTimeout(
								function()
								{
									$('.ltBox_container').html( '<img src="'+ imgSrc +'" alt="-" />' );
									$('.ltBox_container').fadeTo(0,0,function() {
										$('.ltBox_container').fadeTo('slow',1);
									});
									
								}
								, 1000
							);
					}
				});
		    }).attr('src', imgSrc );
		});
	});
	return false;
});