<?php
class OnePage extends CWidget
{


	public $htmlOptions =array();
	public $ARRpage =array();

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
		echo $this->RenderOnePage($this->ARRpage);
	}

	public function RenderOnePage($page)
	{
		
		return '<a target="_blank" href="/'.$page['uri'].'" class="return_for_list non"></a>
				<h1 style="display:none;" id="page_'.$page['id'].'"></h1>
				
				<div class="features_one">
						<div class="features_one_label">Название</div>
						<div class="features_one_input"><input class="page_field" type="text" name="name" id="name__'.$page['id'].'" value="'.$page['name'].'"></div>
				</div>		
				'.(($page['uri'] == 'contacts') ? '
					<div class="block_label">Адрес</div>
					<div class="br"></div>				
					<div class="view_order_details" style="width:330px">
						<div class="page_text" id="addres_'.$page['uri'].'" name="text"  style=" outline:none; margin:0 20px; font-size:14px; min-height:40px; background-color: #FFFFFF;">'.$page['addres'].'</div>
					</div>
						
					<div class="block_label">Режим работы</div>
					<div class="br"></div>				
					<div class="view_order_details" style="width:330px">
						<div class="page_text" id="mode_'.$page['uri'].'" name="text"  style=" outline:none; margin:0 20px; font-size:14px; min-height:40px; background-color: #FFFFFF;">'.$page['mode'].'</div>
					</div>		
						
					<div class="block_label">О нас</div>
					<div class="br"></div>				
					<div class="view_order_details" style="width:100%;">
						<div class="page_text" id="text_'.$page['uri'].'" name="text"  style=" outline:none; margin:0 20px; font-size:14px; min-height:40px; background-color: #FFFFFF;">'.$page['text'].'</div>
					</div>
				
				' : '
					
				').'	
				
				'.(($page['uri'] == '/') ? '
						<div class="block_label">О компании «Флау-вил»</div>
						<div class="br"></div>				
						<div class="view_order_details" style="width:570px;">
							<div class="page_text" id="text_'.$page['uri'].'" name="text"  style=" outline:none; margin:0 20px; font-size:14px; min-height:40px; background-color: #FFFFFF;">'.$page['text'].'</div>
						</div>
						<div class="block_label">Схема проезда</div>
						<div class="br"></div>				
						<div class="view_order_details" style="width:520px">
							<div class="features_one_input"><input style="width:520px" class="page_field"  type="text" name="addres" id="addres__'.$page['id'].'" value="'.$page['addres'].'"></div>
						</div>
				' : '').'
				
				'.(($page['uri'] != '/' && ($page['uri'] != 'contacts')) ? '
						<div class="block_label">uri</div>
						<div class="features_one_input"><input class="page_field" type="text" name="name" id="uri__'.$page['id'].'" value="'.$page['uri'].'"></div>
						<div class="block_label">Содержимое</div>
						<div class="br"></div>				
						<div class="view_order_details" style="width:570px;">
							<div class="page_text" id="text_'.$page['uri'].'" name="text"  style=" outline:none; margin:0 20px; font-size:14px; min-height:40px; background-color: #FFFFFF;">'.$page['text'].'</div>
						</div>' : '').'
				
					<div class="block_label">Сортировка меню (0 - не выводить)</div>
					<div class="features_one_input">
						<input class="page_field" type="text" name="name" id="menu_sort__'.$page['id'].'" value="'.$page['menu_sort'].'">
					</div>				
						
				'.(($page['uri'] != 'minicontacts') ? '
				<div class="block_label"><span class="show_seo green_d">Поисковое продвижение</span></div>
				<div class="seo_input_block">
						
						<div class="features_one">
								<div class="features_one_label">Тайтл</div>
								<div class="features_one_input"><input class="page_field" type="text" name="meta_title" id="meta_title__'.$page['id'].'" value="'.$page['meta_title'].'"></div>
							</div>
						<div class="features_one">
								<div class="features_one_label">Кейвордс</div>
								<div class="features_one_input"><input class="page_field" type="text" name="meta_keywords" id="meta_keywords__'.$page['id'].'" value="'.$page['meta_keywords'].'"></div>
							</div>
						<div class="features_one non_boder_features_one">
								<div class="features_one_label ">Дескрипшен</div>
								<div class="features_one_input"><textarea class="page_field"   name="meta_description" id="meta_description__'.$page['id'].'"  >'.$page['meta_description'].'</textarea></div>
							</div>
						'.(($page['uri'] == '/') ? '
				 		<div class="absolute_left">
							<div class="features_one non_boder_features_one">
								<div class="features_one_label ">Счетчик <span>(Яндекс-метрика, Гугл-аналитикс)</span></div>
								<div class="features_one_input"><textarea style="height:170px;" class="page_field"   name="counter" id="counter__'.$page['id'].'"  >'.$page['counter'].'</textarea></div>
							</div>
						</div>
						' : '').'							
				</div>
				' : '').'							
		';
	}
	
	
}