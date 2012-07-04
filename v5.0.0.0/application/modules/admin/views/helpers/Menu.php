<?php
class Zend_View_Helper_Menu extends Zend_View_Helper_Abstract
{
	public function menu($menuLinks = null)
	{
		$auth = Zend_Auth::getInstance();
		
		if( !$auth->hasIdentity() ) 
		{
			$menu = '';
		}
		else
		{
			$menu  = '			<div id="menu">'. "\n";
			$menu .= '				<ul>'. "\n";
			
			if( $menuLinks )
			{
				foreach ($menuLinks as $key => $value)
				{
					$menu .= '					<li><a href="'.__LINKS__.'admin/'. strtolower( $value['name'] ) .'/list/">'. $value['label'] .'</a></li>'. "\n";
				}
			}
			
			$menu .= '					<li><a href="'.__LINKS__.'admin/login/sign-out/">Sair</a></li>'. "\n";
			$menu .= '				</ul>'. "\n";
			$menu .= '			</div>'. "\n";
		}
		
		return $menu;
	}
}
	