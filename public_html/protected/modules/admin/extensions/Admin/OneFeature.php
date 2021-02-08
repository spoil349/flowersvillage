<?php
class OneFeature extends CWidget
{


	public $htmlOptions =array();
	public $ARRFeature =array();
	public $ARRCategories =array();
	public $TypesFeatures =array();
	
	

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
		echo $this->RenderOneProduct($this->ARRFeature);
		echo '<script>
				 	$(function(){
							$("select").chosen();
					});
				</script>';
	}

	public function RenderOneProduct($ARRFeature) {
		
// 		return'
// 				<h1 style="display:none;" id="feature_'.$ARRFeature['id'].'" ></h1>
// 				'.(($ARRFeature['tocart'] != 1) ? '<div class="delete_feature_block"  ><span class="show_feature '.(($ARRFeature['visibly'] == 0)? 'no_visibly' : '').'" >'.(($ARRFeature['visibly'] == 0) ? 'Показать' :'Скрыть').' свойство</span><span class="delete_feature" >Удалить свойство</span></div>
// 				<div class="admin_checkbox_faetures" style="margin-bottom:20px; font-weight:bold;"><label>Техническое свойство для склада</label>&nbsp;<input id="admin_checkbox" type="checkbox" '.(($ARRFeature['admin'] == 1) ? 'checked="checked" class="check_on"' : '' ).' ></div>
// 				<label style="display:inline-block; margin-bottom:20px; width:505px">Тип свойства</label>
// 				<label style="display:inline-block; margin-bottom:20px;" >Использовать в категориях</label>
// 				<div class="chose_type_feature">
					
// 					'.$this->renderChoseTypeFeature($ARRFeature['type']).'		
// 					<div class="br"></div>
// 				</div>
// 				' : '').'		
// 				<div class="values_for_type">
// 					<div class="values_select one_type_values">
// 							<label>Значения</labeL>
// 							<div class="one_type_values_line">
// 							'.$this->renderValuesType($ARRFeature['variants']).'
// 							</div>
// 							<div style="width:420px; text-align:right;"><span class="add_values_option">Добавить значение</span></div>
// 					</div>
// 				</div>
// 				'.(($ARRFeature['tocart'] != 1) ? '
// 					<div class="select_category">
// 					'.$this->renderCategoriesFeature($ARRFeature['categories'], 'features_categories').'
// 					</div>
// 					<div class="br"></div>
// 					' : '').'		
// 			';

		return'
			<h1 style="display:none;" id="feature_'.$ARRFeature['id'].'" ></h1>

			<div class="features_one">
				<div class="features_one_label">Название</div>
				<div class="features_one_input"><input class="feature_field" maxlength="40" type="text" name="name" id="name__'.$ARRFeature['id'].'" '.((isset($_GET['new']) && $_GET['new'] = '1') ? 'placeholder' : 'value').'="'.$ARRFeature['name'].'" '.(($ARRFeature['tocart'] == 1) ? 'disabled="disabled"' :'').'></div>
			</div>
			'.(($ARRFeature['tocart'] != 1) ? '
			<div class="features_one">
				<div class="features_one_label">Тип</div>
				<div class="features_one_input">'.$this->renderChoseTypeFeature($ARRFeature['type']).'</div>
			</div>			
				
			' : '').'
			<div class="values_for_type">
				<div class="features_one">
					<div class="features_one_label">Значения</div>
					<div class="features_one_input">
						<div class="one_type_values_line">
							'.$this->renderValuesType($ARRFeature['variants']).'
							</div>
							<div class="one_value add_values_option"></div>
					</div>
				</div>	
			</div>
			'.(($ARRFeature['tocart'] != 1) ? '

			<div class="features_one">
				<div class="features_one_label">Продукты категорий</div>
				<div class="features_one_input select_category">'.$this->renderCategoriesFeature($ARRFeature['categories'], 'features_categories').'</div>
			</div>
			<div style="width:920px; height:1px;background-color:#ddd; margin:25px 0px 25px -40px;"></div>					
			<span class="red_btn btn_def delete_feature">Удалить</span>
			<span style="margin-left:17px;" class="gray_btn btn_def show_feature '.(($ARRFeature['visibly'] == 0) ? 'no_visibly' : '').'">'.(($ARRFeature['visibly'] == 0) ? 'Показать' : 'Скрыть').' </span>
			
			' : '').'		
		';
			
		
	}
	
	
	public function renderValuesType($ARRvar ) {
		$line_input = '';
		$ARR = explode('|', $ARRvar);
		if ($ARR[0] != '') {
			foreach($ARR as $V){
	
				$line_input .= '<div class="one_value" ><input class="values_select_option" type="text" value="'.$V.'" placeholder="Вариант значения" /><span style=""><img src="/images/del.png"></span></div>';
			}
		} else {
			$line_input = '<div class="one_value" ><input class="values_select_option" type="text" value="" placeholder=" " /><span style=""><img src="/images/del.png"></span></div>
							<div class="one_value" ><input class="values_select_option" type="text" value="" placeholder=" " /><span style=""><img src="/images/del.png"></span></div>		
			';
		}
		
		return $line_input;
	}
	
		
	public function renderCategoriesFeature($ARRcat, $id) {
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
	
	public function renderChoseTypeFeature($type ) {
		$option = '';
		foreach ($this->TypesFeatures as $K => $V) {
			$select = '';
				if ($V['type'] == $type ) {
					$select ='selected="selected"';
				}
			$option .= '<option  '.$select.' value="'.$V['type'].'" >'.$V['name'].'</option>';
		}
	
		return  '<select data-placeholder=" "  id="type_shoce" name="chose_type_feature" >'.$option.'</select>';
	}
}