<?php
class Zend_View_Helper_Breadcrumbs extends Zend_View_Helper_Abstract
{
	public function Breadcrumbs($breadcrumb = null)
	{
		$menu = '';
		if( $breadcrumb ) 
		{
			$menu .= '			<div id="breadcrumb">'. "\n";
			$menu .= '				<ul>'. "\n";
			
			foreach ($breadcrumb as $key => $value)
			{
				$key == '#' 
					? $menu .= '					<li><span> &raquo; '. $value .'</span></li>'. "\n"
					: $menu .= '					<li><a href="'.__LINKS__.'admin/'. strtolower( $key ) .'"> &raquo; '. $value .'</a></li>'. "\n";
			}
			
			$menu .= '				</ul>'. "\n";
			$menu .= '			</div>'. "\n";
		}
		return $menu;
	}
}
	