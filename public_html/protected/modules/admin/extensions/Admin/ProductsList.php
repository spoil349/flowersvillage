<?php

class ProductsList extends CWidget
{
	
	
	public $htmlOptions =array();
	public $ARRitems =array();
	public $ARRfields = array();
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
		echo '<div class="orders products">';
		echo '<div class="product_top_count_panel">
				<span class="top_span top_active">Активных: <b>'.$this->ACTIVEcount.'</b></span>
				<span class="top_span top_category">В категории: <b>'.$this->CATcount.'</b></span>
				<span class="top_span top_all">Всего: <b>'.$this->ALLcount.'</b></span>
			</div>';
		echo $this->RenderRow($this->row);
		echo '</div>';
	}
	
	public function RenderRow($row)
	{

		if (count($row) > 0){
			$onehead= '
					<thead>
						<tr  class="one_order_header">
							
							<th class="name_header" style="width:200px; padding-left:5px;">Наименование</th>
							<th class="cat_header">Категория</th>
							<th class="price_header">Стоимость</th>
							<th class="size_header">Размеры</th>
							<th class="img_header">Картинки</th>
							<th class="rating_header">Рэйтинг</th>
							<th class="vizible_header">Виден</th>
							<th class="panel"></th>
						</tr>
					</thead>
				';
			$one ='';
			$a = 1;
			foreach ($row as $K =>$V){
				if ($a == 1) { $class="fon"; $a = 0;}
				elseif ($a == 0) {$class=""; $a = 1;}
				if ($this->cat != 'deleted'){ $panel = '
						<td id="panel_'.$V['id'].'" class="panel_order panel_product">
									<span class="list_button_active '.(($V['no_active'] == 1)? '' : 'no_').'active_orders" id="'.(($V['no_active'] == 1)? '' : 'no_').'active'.$V['id'].'"></span>
									<span class="panel_edit"><a href="/admin/products/'.$this->cat.'/'.$V['id'].'"><img src="/images/cat_edit.png"></a></span>
									<span class="panel_del" id="del'.$V['id'].'"><img src="/images/del.png"></span>
						</td>';
				}else {
					$panel = '';
				}	
				
					$arr_rating = '';
					if (!isset($V['rating']) || $V['rating'] == ''){
						$row['rating'] = 0;
					}
					$i=1;
					while ($i<=5) {
						if ((int)$V['rating'] == $i) {$checked = 'checked="checked"';}else {$checked = '';}
						$arr_rating .= '<input id="rating_'.$i.'"class="rating_'.$K.'"  value="'.$i.'" '.$checked.'></input>';
						$i++;
					}
						$count_imgARR = array_filter( explode('|',$V['img']), function($el){ return !empty($el);});
					
						$rating = '
						<script>$(function(){ $(".rating_'.$K.'").rating({readOnly: true}); });</script>
							<div class="all_raiting">'.$arr_rating.'<div class="br"></div>
						</div>
						';
						$one .= '<tr id="product_'.$V['id'].'" class="one_order '.$class.'">
						
						<td id="name_'.$V['id'].'" contenteditable="false" class="name_order" style="min-width:280px;max-width:280px; overflow:hidden;padding-left:5px;"><a href="/admin/products/'.$this->cat.'/'.$V['id'].'">'.$V['name'].'</a></td>
						<td id="cat_id_'.$V['id'].'" class="price_order">'.$this->Allstatus[$V['cat_id']]['name'].'</td>	
						<td id="price_'.$V['id'].'" contenteditable="false" class="price_order">'.$V['price'].' р</td>
						<td id="size_'.$V['id'].'" class="size_order" style="min-width:100px; font-size:13px;">'.str_replace('|', ' ', $V['sizes']).'</td>
						<td id="image_'.$V['id'].'" class="img_order">'.count( $count_imgARR).'</td>
						<td id="rating_'.$V['id'].'" class="rating_order">'.$rating.'</td>	
						<td id="no_active_'.$V['id'].'" class="td_active_order">'.(($V['no_active'] == 0)? 'да' : 'нет').'</td>
						'.$panel.'	
						';
			}
			
			return '
					
					<table style="'.(($this->cat != 'deleted')? 'width:110%; margin-left:0%': 'width:100%; margin-left:0%').'" cellpadding="0" cellspacing="0" >'.$onehead.'<tbody>'.$one.'</tbody></table>
			';
			
		}else {
			return '
					<div class="orders_mess">Нет заказов...</div>
			';
		}
	}
	
	
}
	

//