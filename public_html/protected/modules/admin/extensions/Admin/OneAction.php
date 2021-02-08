<?php
class OneAction extends CWidget
{

	public $ARRAction =array();
	public $TypesActions =array();
	public $ARRCategories =array();
	
	

	public function init()
	{
		$route=$this->getController()->getRoute();
		//	$this->items=$this->normalizeItems($this->items,$route,$hasActiveChild);
	}

	/**
	 * Calls {@link renderMenu} to render the menu.
	 */
	public function run()
	{
		echo $this->RenderOneProduct($this->ARRAction);
		echo '<script>
				 	$(function(){
							$("select").chosen();
					});
				</script>';
	}

	public function RenderOneProduct($ARRAction) {
		
		$ARR_date = explode(' ', $ARRAction['datetime']);
		$date = $ARR_date[0];
		$ARR_time = explode(':', $ARR_date[1]);
		
		$hourse = $ARR_time[0];
		$min = $ARR_time[1];
		
		
		return'<a target="_blank" href="/actions/'.$ARRAction['id'].'" class="return_for_list non"></a>
				<h1 style="display:none;" id="action_'.$ARRAction['id'].'" ></h1>
				
				<div class="features_one">
						<div class="features_one_label">Название</div>
						<div class="features_one_input"><input class="action_field" maxlength="40" type="text" name="name" id="name__'.$ARRAction['id'].'" value="'.$ARRAction['name'].'"></div>
				</div>
			'.((0) ? '
				<div class="features_one">
						<div class="features_one_label">Категории</div>
						<div class="features_one_input select_category">'.$this->renderCategoriesAction($ARRAction['categories'], 'actions_categories').'</div>
				</div>			
			' : '').'
			
			'.((0)? '
				<div class="features_one values_action one_type_values">
							<div class="features_one_label">Время окончания, ГГГГ-ММ-ДД чч:мм</div>
							<div class="br"></div>
							<div style="float:left" class="value_action datetime_action">
								<input style="width:100px" id="actions_ts_date" name="date" class="calendar_date" type="text" value="'.$date.'" placeholder="0000-00-00"><div class="date_bg"></div>
							</div>
							<div style="float:left; margin-left:82px;"  class="value_action datetime_action">
								<input style="width:20px" id="actions_ts_hourse" name="hourse" type="text" value="'.$hourse.'" placeholder="00">  : <input style="width:20px" id="actions_ts_min" name="min" type="text" value="'.$min.'" placeholder="00"> 
							</div>
							<div class="br"></div>
							<div class="value_action" style="margin-top:10px;">
								<input class="'.(($ARRAction['datetime'] == '0000-00-00 00:00:00') ? 'available_checkbox' : '').'" style="width:15px; margin:0;padding:0; margin-right:10px;" id="actions_ts_checkbox" name="" '.(($ARRAction['datetime'] == '0000-00-00 00:00:00') ? 'checked="checked"' : '').' type="checkbox" value="0"><label for="actions_ts_checkbox"  style="font-weight: normal; margin-top:-3px;display:inline-table;cursor:pointer;">Бессрочно</label>  
							</div>
					</div>
						
			' : '').'
				<div class="features_one" >
						<div class="features_one_label">Краткое описание</div>
						<div class="features_one_input"><input class="action_field" type="text" name="title" id="title__'.$ARRAction['id'].'" value="'.$ARRAction['title'].'"></div>
				</div>
				<div class="absolute_left">
						
						<div class="features_one" style="margin-left:0;">
								<div class="features_one_label">Полное описание</div>
								<div class="features_one_input"><textarea style="height:206px" class="action_field" type="text" name="description" id="description__'.$ARRAction['id'].'" >'.$ARRAction['description'].'</textarea></div>
						</div>
				</div>
				
			
				<div class="block_label">Превью акции</div>
				<div class="features_one_input">
					'.$this->renderActionImg($ARRAction['img']).'
					<div class="br"></div>
					<input type="file"  multiple="multiple " style="display:none;" id="action_img">	
				</div>
				<div class="block_label"><span class="show_seo green_d">Поисковое продвижение</span></div>
				<div class="seo_input_block">
						<div class="features_one">
								<div class="features_one_label">Тайтл</div>
								<div class="features_one_input"><input class="action_field" type="text" name="meta_title" id="meta_title__'.$ARRAction['id'].'" value="'.$ARRAction['meta_title'].'"></div>
						</div>
						<div class="features_one">
								<div class="features_one_label">Кейвордс</div>
								<div class="features_one_input"><input class="action_field" type="text" name="meta_keywords" id="meta_keywords__'.$ARRAction['id'].'" value="'.$ARRAction['meta_keywords'].'"></div>
						</div>
						<div class="features_one non_boder_features_one">
								<div class="features_one_label ">Дескрипшен</div>
								<div class="features_one_input"><textarea class="action_field"   name="meta_description" id="meta_description__'.$ARRAction['id'].'"  >'.$ARRAction['meta_description'].'</textarea></div>
						</div>						
				</div>
				<div style="width:920px; height:1px;background-color:#ddd; margin:25px 0px 25px -40px;"></div>					
				<span class="red_btn btn_def delete_action">Удалить</span>
				<span style="margin-left:17px;" class="gray_btn btn_def show_action '.(($ARRAction['visibly'] == 0) ? 'no_visibly' : '').'">'.(($ARRAction['visibly'] == 0) ? 'Показать' : 'Скрыть').' </span>	
				
				
			';
		//<div style="float:left; margin-top:0;" class="block_label">Изображения Акции (960x393):</div><div style="float:right;margin-top:0;" class="button_add_img_div"><span id="button_add_img"  style="width:180px;" class="green_buttons button_add_img">Добавить изображение</span><img id="img_button_add_img" src="/images/img_icon.png"><input id="add_img_input" class="input_selected_click" type="file" style="display:none;"></div>
	}
	public function renderActionPreview($img, $size) {
		$ArrPreviewSize = explode('x', $size);
		
		
		$line_img = '<div class="action_preview" data-size="'.$size.'">';
	
		if ($img != '') {
			$arrimg = explode('|', $img);
	
			$C = 0;
			foreach($arrimg as $V ) {
				if ($V != ''){
					$line_img .= '
						<div class="one_preview_img_product float" id="img'.$C.'">
							<div class="one_preview_div_img"><img src="/uploads/'.$V.'" ></div>
							<span id="del'.$C.'" class="del"></span>
						</div>';
					$C++;
				}
			}
		}
	
		$line_img .= '<div class="action_preview_border" ></div></div>
			<style>
			.action_preview .one_preview_div_img, .action_preview .one_preview_img_product {width:'.(((int)$ArrPreviewSize[0]/3)).'px;  height:'.(((int)$ArrPreviewSize[1]/3)).'px}
			.action_preview .action_preview_border {width:'.(((int)$ArrPreviewSize[0]/3) - 4).'px;  height:'.(((int)$ArrPreviewSize[1]/3) - 4).'px}
			</style>	
		';
		return $line_img;
	}
	
	public function renderActionImg($img) {
	
		$line_img = '<div class="action_img" data-size="230x225">';
	
		if ($img != '') {
			$arrimg = explode('|', $img);
	
			$C = 0;
			foreach($arrimg as $V ) {
				if ($V != ''){
					$line_img .= '
						<div class="one_preview_img_product float" id="img'.$C.'">
							<div class="one_preview_div_img"><img src="/uploads/'.$V.'" ></div>
							<span id="del'.$C.'" class="del"></span>
						</div>';
					$C++;
				}
			}
		}
	
		$line_img .= '<div class="action_img_border" ></div></div>
		';
		return $line_img;
	}
	
	public function renderValuesType($ARRvar ) {
		$line_input = '';
		$ARR = explode('|', $ARRvar);
		if ($ARR[0] != '') {
			foreach($ARR as $V){
	
				$line_input .= '<div><input class="values_select_option" type="text" value="'.$V.'" placeholder="Вариант значения" /><span style="padding-left:10px;"><img src="/images/del.png"></span></div>';
			}
		} else {
			$line_input = '<div><input class="values_select_option" type="text" value="" placeholder=" " /><span style="padding-left:10px;"><img src="/images/del.png"></span></div>
							<div><input class="values_select_option" type="text" value="" placeholder=" " /><span style="padding-left:10px;"><img src="/images/del.png"></span></div>		
			';
		}
		
		return $line_input;
	}
	
	
	public function renderCategoriesAction($ARRcat, $id) {
		$option = '';
		foreach ($this->ARRCategories as $K => $V) {
			$select = '';
			foreach($ARRcat as $V2){
				if ($V['id'] == $V2['cat_id']) {
					$select ='selected="selected"';
				} 
			}
			$option .= '<option  '.$select.' value="cat_'.$V['id'].'">'.$V['name'].'</option>';
		}
	
		return  '<select  data-placeholder=" "  multiple="true" name="" id="'.$id.'">'.$option.'</select>
				';
	}
	
	public function renderChoseTypeAction($type ) {
		$option = '';
		foreach ($this->TypesActions as $K => $V) {
			$select = '';
				if ($V['type'] == $type ) {
					$select ='checked="checked"';
				}
			$option .= '<div class="one_type"><input  id="type_shoce" '.$select.' type="radio" name="chose_type_feature" value="'.$V['type'].'"><label for="type_'.$K.'" >'.$V['name'].'</label></div>';
		}
	
		return  $option;
	}
}