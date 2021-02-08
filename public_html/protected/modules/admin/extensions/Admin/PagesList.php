<?php

class PagesList extends CWidget
{
	
	
	public $htmlOptions =array();
	public $row =array();
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
		//echo '<div  style="margin:0 0 10px 5px;font-size:14px; color:#4cb86f; font-weight:bold;">Кликните двойным щелчком чтобы редактировать поле!</div>';
		echo '<div class="orders pages">';
		echo $this->RenderRow($this->row);
		echo '</div>';
	}
	
	public function RenderRow($row)
	{

		if (count($row) > 0){
			$onehead= '
					<thead>
						<tr  class="one_order_header">
							
							<th class="name_header" style="width:200px; padding-left:5px;text-align:left;">Название</th>
							<th class="cat_header">Загаловок</th>
							<th class="cat_header">Ключевые_слова</th>
							<th class="cat_header" style="">Описание</th>
							<th class="cat_header" style="">Текст Страницы</th>
						</tr>
					</thead>
				';
			$one ='';
			$a = 1;
			foreach ($row as $K =>$V){
				$panel = '
						<td id="panel_'.$V['id'].'" class="panel_order panel_pages">
									<span id="edit'.$V['id'].'" class="panel_edit"><a href="/admin/pages/'.$V['id'].'"><img src="/images/cat_edit.png"></a></span>
						</td>';
				
				$one .= '<tr id="page_'.$V['id'].'" class="one_order" style="max-height:200px; width:100%; overflow:hidden;">
						
						<td id="name-'.$V['id'].'" class="name_cat can_edit" style="min-width:150px; max-width:150px; overflow:hidden;"><a href="/admin/pages/'.$V['id'].'">'.$V['name'].'</a></td>
						<td id="meta_title-'.$V['id'].'"  class="meta_title_page can_edit">'.$V['meta_title'].'</td>	
						<td id="meta_keywords-'.$V['id'].'"  class="meta_keywords_page can_edit">'.$V['meta_keywords'].'</td>	
						<td id="meta_description-'.$V['id'].'" class="meta_description_page can_edit" style="width:200px; ">'.$V['meta_description'].'</td>	
						<td id="text-'.$V['id'].'" class="text_page can_edit" style="min-width:150px; max-width:150px; "><div style="width:100%; height:100px;overflow:hidden;" >'.$V['text'].'</div></td>
						'.$panel.'	
						';
			}	
			return '
					
					<table style="width:105%; margin-left:0%" cellpadding="0" cellspacing="0" >'.$onehead.'<tbody>'.$one.'</tbody></table>
			';
			
		}else {
			return '
					<div class="orders_mess">Нет заказов...</div>
			';
		}
	}
	
	
}
	

//