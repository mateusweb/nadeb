<?php
class Zend_View_Helper_SideBar extends Zend_View_Helper_Abstract
{
	public function sidebar($sideBarlinks = null)
	{
		$sidebar  = '<ul>' . "\n";
		
		if($sideBarlinks)
		{
			$i = 0;
			foreach ($sideBarlinks as $key => $value)
			{
				$sidebar .= '	<li>' . "\n";
				$sidebar .= '		<a href="#sideBar'.$i.'" class="sideBarTitle">'. $value['label'] .'</a>' . "\n";
				$sidebar .= '		<ul id="sideBar'.$i.'Menu">' . "\n";
				foreach ($value['dependent'] as $depKey => $depValue)
				{
					$sidebar .= '			<li><a href="'.__LINKS__. $depValue['link'] .'">'. $depValue['name'] .'</a></li>' . "\n";
				}
				$sidebar .= '		</ul>' . "\n";
				$sidebar .= '	</li>' . "\n";
				$i++;
			}
		}
		
		$sidebar .= '</ul>' . "\n";
		
		if ($this->view->search)
		{
			$sidebar .= '<ul id="search-wrapper">' . "\n";
			$sidebar .= '	<li id="search">' . "\n";
			$sidebar .= '		<h4>Busca <a href="#">[ x ]</a></h4>' . "\n";
			$sidebar .= $this->view->search;
			$sidebar .= '	</li>' . "\n";
			$sidebar .= '</ul>' . "\n";
		}

		$auth = Zend_Auth::getInstance();
		if( !$auth->hasIdentity() ) $sidebar = '';
		
		return $sidebar;
	}
}
	