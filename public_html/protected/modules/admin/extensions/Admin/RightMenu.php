<?php
class RightMenu extends CWidget
{


	public $htmlOptions =array();
	public $row = array();
	public $select_uri = '';
	public $map_url = '';
	public $All_label = 'Все товары';
	public $Field_name = 'name';
	
	public function init()
	{
		$this->htmlOptions['id']=$this->getId();
		$route=$this->getController()->getRoute();
	}

	/**
	 * Calls {@link renderMenu} to render the menu.
	 */
	public function run()
	{	
		echo '<script>
				 	$(function(){
								$(document).ready(function(){
								    $(".content_right_menu").sticky({topSpacing:60});
								});
					});
			</script>';
		echo $this->RenderMenu();
	}

	private function RenderMenu()
	{
		
		$menu = '';
		$select= false;
		foreach ($this->row as $V){
		    $url = str_replace('{uri}', $V['uri'] , $this->map_url); 
			if ($url ==  $this->select_uri){
				$select = true;
				$menu .= '<div class="content_right_menu_one"><a class="menu_select" href="'.$url.'">'.$V[$this->Field_name].'</a></div>';
			}else {
				$menu .= '<div class="content_right_menu_one">
					<a href="'.$url.'">'.$V[$this->Field_name].'</a>		
				</div>';
			}	
		}
		if(strpos($this->map_url,'orders') !== false) {
			$add = '<a href="/admin/orders/import/">Выгрузить заказы в csv</a>';
		} else {
			$add = '';
		}
		echo $add;
		return '
				<div class="content_right_menu">
					<div class="content_right_menu_one top_menu"><a '.((!$select)? 'class="menu_select"' : '').' href="'.str_replace('/{uri}','' , $this->map_url).'">'.$this->All_label.'</a></div>
					'.$menu.'
					<div class="br"></div>
				</div>
				';
	}
}