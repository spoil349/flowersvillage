<?php
class AdminMenu extends CWidget
{


	public $htmlOptions =array();
	public $row = array();
	public $select_uri = '';

	
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
		echo $this->RenderMenu();
	}

	private function RenderMenu()
	{
		$sel = '/admin';
		$menu = '';
		foreach ($this->row as $V){

			if ($V['uri'] == $this->select_uri || $V['uri'].'/list/' == $this->select_uri.'') {
				$menu .= '<div class="one_admin_menu_wid menu_admin_select">'.$V['label'].'</div>';
				$sel = $V['uri'];
			}elseif (preg_match('/'.str_replace('/', '', $V['uri']).'/', str_replace('/', '', $this->select_uri)) && $V['uri'] != $this->select_uri){
				$menu .= '<div class="one_admin_menu_wid "><a class="admin_select" href="'.$V['uri'].'">'.$V['label'].'</a></div>';
				$sel = $V['uri'];
			}else {
				$menu .= '<div class="one_admin_menu_wid">
					<a href="'.$V['uri'].'">'.$V['label'].'</a>		
				</div>';
			}	
		}
		
		return '
				
				<div class="admin_menu_wid">	
					<div class="admin_menu_wid_cont">
						<div class="logo"><a class="non" href="/"><img src="/img/logo.jpg"></a></div>
						<div class="admin_menu_wid_cont_bg">
							'.$menu.'
							<div class="br"></div>
						</div>
						<a href="/admin/products/new/" class="green_btn btn_def2 add_product">Добавить товар...</a>
					</div>
					<div class="br"></div>
				</div>
							
				';
	}
}