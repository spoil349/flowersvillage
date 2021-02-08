<?php
class MenuProducts extends CWidget
{


	public $htmlOptions =array();
	public $cat = '';
	public $Allstatus =array();
	public $Allcount = 0;

	public function init()
	{
		$this->htmlOptions['id']=$this->getId();
		$route=$this->getController()->getRoute();
		//	$this->items=$this->normalizeItems($this->items,$route,$hasActiveChild);
	}

	/**
	 * Calls {@link renderMenu} to render the menu.
	 */
	public function run()
	{
		//echo $this->RenderStatusMenu($this->Allstatus);
		echo $this->renderMenu($this->Allstatus);
	}

	public function RenderStatusMenu($Arrstat)
	{
		$menu = '';
		foreach ($Arrstat as $V){
			if ($V['uri'] == $this->cat){
				$menu .= '<div class="one_menu_status select"><a class="link_select" href="/admin/products/'.$V['uri'].'">'.$V['name'].' <span><span></a></div>';
			}else {
				$menu .= '<div class="one_menu_status">
					<a href="/admin/products/'.$V['uri'].'">'.$V['name'].'</a>		
				</div>';
			}	
		}
		
		return '<div class="orders_menu products_menu">
					<div class="menu_label">Всего '.$this->Allcount.' Продукта(ов)</div>
					'.$menu.'
				</div>';
	}



	protected function renderMenu($items)
	{
		$line_menu_add = '';
		$line_menu = '';

		$i = 0;
			
			$line_menu_add = '';
			
		foreach($items as $item)
		{
			$edit = '<img src="/images/cat_edit.png">';
			if($this->cat == $item['uri'] ) {$select = 'select'; $count = '';} else { $select = ''; $count = '';}
			$line_menu .= '<div class="one_menu" id="cont_'.$item['id'].'">
											<div type="'.$item['uri'].'" id="label_'.$item['id'].'" class="one_menu_label '.$select.'"><a href="/admin/products/'.$item['uri'].'" >'.$count.' '.$item['name'].' </a></div>
											<div class="br"></div>
								</div>';
		}


		echo '<div class="all_menu">'.$line_menu_add.'<div id="authorized_all_menu">'.$line_menu.' </div></div>';
	}


}
//