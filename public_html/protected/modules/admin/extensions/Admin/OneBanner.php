<?php
class OneBanner extends CWidget
{

	public $ARRAction =array();

	
	

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
		
		
		return'
				<h1 style="display:none;" id="action_'.$ARRAction['id'].'" ></h1>
				
				<div class="features_one">
						<div class="features_one_label">Название</div>
						<div class="features_one_input"><input class="action_field" maxlength="40" type="text" name="name" id="name__'.$ARRAction['id'].'" value="'.$ARRAction['name'].'" placeholder="'.(($ARRAction['name'] == '') ? 'Баннер номер '.$ARRAction['id'] : '').'"></div>
				</div>
				
				<div class="features_one" >
						<div class="features_one_label">Краткое описание</div>
						<div class="features_one_input"><textarea style="height:60px;" class="action_field" type="text" name="title" id="title__'.$ARRAction['id'].'" >'.$ARRAction['title'].'</textarea></div>
				</div>
				<div class="features_one" >
						<div style="float:left" class="features_one_label">Плашка</div>
						<div style="float:left; margin-top:-2px; width:20px" class="features_one_input"><input style="width:20px" type="checkbox" class="action_field" type="text" name="plashka"  id="plashka__'.$ARRAction['id'].'" '.(($ARRAction['plashka'] == 1) ? 'checked="checked"' : '').' value="1" ></div>
						<div class="br"></div>
				</div>
				<div class="features_one" >
						<div class="features_one_label">Ссылка</div>
						<div class="features_one_input"><input class="action_field" type="text" name="link" id="link__'.$ARRAction['id'].'" value="'.$ARRAction['link'].'"></div>
				</div>				
				<div class="block_label">Баннер</div>
				<div class="features_one_input">
					'.$this->renderActionPreview($ARRAction['preview'], $ARRAction['size'] ).'
					<div class="br"></div>
					<input type="file"  multiple="multiple " style="display:none;" id="preview_img">	
				</div>
					
		
				
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