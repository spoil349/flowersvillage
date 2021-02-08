<?php
class OneProduct extends CWidget
{


	public $htmlOptions =array();
	public $ARRitem =array();
	public $ARRcat =array();
	public $ARRaction =array();

	/**
	 * Calls {@link renderMenu} to render the menu.
	 */
	public function run()
	{
		echo $this->RenderOneProduct($this->ARRitem);
	}

	public function RenderOneProduct($product) {
		
		//EA($product);
		
		$arr_rating = '';
		if (!isset($product['rating']) || $product['rating'] == ''){
			$product['rating'] = 0;
		}
		$i=1;
		while ($i<=5) {
			if ((int)$product['rating'] == $i) {$checked = 'checked="checked"';}else {$checked = '';}
			$arr_rating .= '<input id="rating_'.$i.'"class="rating"  value="'.$i.'" '.$checked.'></input>';
			$i++;
		}
		
		$check_hot = false;
		foreach ($product['categories'] as $cat) {
			if ($cat['tocatalog'] == 1)
				$check_hot = true;
		}
// 		<div class="delete_show_product_block">
// 		<span style="width:100px;" class="green_buttons show_product '.(($product['visibly'] == 0) ? 'no_visibly' : '').'">'.(($product['visibly'] == 0) ? 'Показать' : 'Скрыть').' товар</span>
// 		<span style="width:100px;" class=" green_buttons delete_product">Удалить товар</span>
// 		</div>
		$c = current($this->ARRitem['categories']);
		
		return'
				<a target="_blank" href="/catalog/'.$c['uri'].'/'.$product['id'].'" class="return_for_list non"></a>
				'.(($product['instagram_hash'] != '')? '<div class="product_instagram"></div>' : '').'
				<h1 style="display:none;" id="product_'.$product['id'].'" ></h1>
		
				<div class="features_one">
						<div class="features_one_label">Название</div>
						<div class="features_one_input"><input class="product_field" maxlength="40" type="text" name="name" id="name__'.$product['id'].'" '.((isset($_GET['new']) && $_GET['new'] = '1') ? 'placeholder' : 'value').'="'.$product['name'].'"></div>
				</div>
				'.((isset($product['feature_price']))? '
					<div class="features_one">
						<div class="features_one_label">Цена, рублей &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$product['feature_price']['name'].'</div>
						<div class="features_one_input feature_product_price" id="feature_price__'.$product['feature_price']['feature_id'].'" >'.$this->FeatureVariantsPrice($product).'</div>
					</div>		
						
				' : '
					<div class="features_one">
						<div class="features_one_label">Цена, рублей</div>
						<div class="features_one_input"><input class="product_field small_input" type="text" name="price" id="price__'.$product['id'].'" '.((isset($_GET['new']) && $_GET['new'] = '1') ? 'placeholder' : 'value').'="'.number_format($product['price'], 0, ',', ' ' ).'"></div>
					</div>	
						
				').'
				
				<div class="features_one">
						<div class="features_one_label">Категория</div>
						<div class="features_one_input">'.$this->getCategorySelect($this->ARRcat).'</div>
				</div>
					
				<div id="features_block">'.$this->renderFeatures($product['features_products'], 'features_products').'</div>
				
				<div class="features_one">
						<div class="features_one_label">Акции</div>
						<div class="features_one_input">'.$this->getActionSelect($product['actions_products'], 'action_products').'</div>
				</div>
				
				<div class="features_one">
					<div class="features_one_label">Сортировка (по возрастанию)</div>
					<div class="features_one_input"><input class="product_field" maxlength="40" type="text" name="orders" id="orders__'.$product['id'].'" '.((isset($_GET['new']) && $_GET['new'] = '1') ? 'placeholder' : 'value').'="'.$product['orders'].'"></div>
				</div>
						
				<div class="br"></div>
				<div class="block_label" style="margin-top:60px;">Изображения товара</div><input id="add_img_input" multiple="multiple " class="input_selected_click" type="file" style="display:none;" >
				'.$this->renderProductImages($product['img'], 'product_img_block').'
				<div class="br"></div>
				<div class="block_label">C этим товаром покупают</div>
				
				'.$this->RenderOthersProducts($product['others_products'], 'product_img_block').'
				<div class="br"></div>
				<div class="br"></div>
				<div class="block_label"><span class="show_seo green_d">Поисковое продвижение</span></div>
				<div class="seo_input_block">
						
						<div class="features_one">
								<div class="features_one_label">Тайтл</div>
								<div class="features_one_input"><input class="product_field" type="text" name="meta_title" id="meta_title__'.$product['id'].'" value="'.$product['meta_title'].'"></div>
						</div>
						<div class="features_one">
								<div class="features_one_label">Кейвордс</div>
								<div class="features_one_input"><input class="product_field" type="text" name="meta_keywords" id="meta_keywords__'.$product['id'].'" value="'.$product['meta_keywords'].'"></div>
						</div>
						<div class="features_one non_boder_features_one">
								<div class="features_one_label ">Дескрипшен</div>
								<div class="features_one_input"><textarea class="product_field"   name="meta_description" id="meta_description__'.$product['id'].'"  >'.$product['meta_description'].'</textarea></div>
						</div>						
				</div>
				<div style="width:920px; height:1px;background-color:#ddd; margin:25px 0px 25px -40px;"></div>					
				<span class="red_btn btn_def delete_product">Удалить</span>
				<span style="margin-left:17px;" class="gray_btn btn_def show_product '.(($product['visibly'] == 0) ? 'no_visibly' : '').'">'.(($product['visibly'] == 0) ? 'Показать' : 'Скрыть').' </span>
			';
			
// 		<div class="absolute_left">
// 		<div class="features_one non_boder_features_one">
// 		<div class="features_one_label ">Счетчик <span>(Яндекс-метрика, Гугл-аналитикс)</span></div>
// 		<div class="features_one_input"><textarea style="height:170px;" class="product_field"   name="meta_description" id="meta_description__'.$product['id'].'"  >'.$product['meta_description'].'</textarea></div>
// 		</div>
// 		</div>
	} 
	
	
	public function FeatureVariantsPrice($product) {
		$feature = $product['feature_price'];
		$Arrvar = explode('|', $feature['variants']);
		$line = '';
		foreach($feature['prices'] as $V) {
			if (isset($V['price']) && isset($V['value'])){
				$line .= '
					<div class="feature_one_price">
	 					<input type="text" class="w120 feature_price" value="'.number_format($V['price'], 0, ',', ' ' ).'">
	 					<select class="w120 feature_price_value" data-placeholder=" " >'.$this->FeaturePriceOptionsSelect($Arrvar, $V['value']).'</select>
	 					<div class="del"><img src="/images/del.png"></div>
	 				</div>		
				';
			}
		}

		
		
 		return '
 				'.(($line != '') ? $line : '
 					<div class="feature_one_price ">
 					<input type="text" class="w120 feature_price" '.((isset($_GET['new']) && $_GET['new'] = '1') ? 'placeholder' : 'value').'="'.(($line == '') ? $product['price'] : '').'">
 					<select class="w120 feature_price_value"  data-placeholder=" " >'.$this->FeaturePriceOptionsSelect($Arrvar, '').'</select>
 					<div class="del"><img src="/images/del.png"></div>
 					</div>		
 				').'
 				<div class="feature_one_price tmp ">
 					<input type="text" class="w120 feature_price" value="">
 					<select class="w120 feature_price_value"  data-placeholder=" " >'.$this->FeaturePriceOptionsSelect($Arrvar, '').'</select>
 					<div class="del"><img src="/images/del.png"></div>
 				</div>
 				<div class="feature_one_price border" id="add_feature_price"></div>
 				
 				';
	}
	
	
	public function FeaturePriceOptionsSelect($Arrvar, $value) {
		$option = '';
		foreach($Arrvar as $var) {
			$option .= '<option '.(($var == $value)? 'selected="selected"' : '' ).' value="'.$var.'">'.$var.'</option>';
		}
		
		return '<option value=""> </option>'.$option;
	}
	
	public function getActionSelect($ARR, $id) {
		$option = '';
// 		echo '<pre>';
// 		print_r($ARR);
// 		echo '</pre>';

		foreach ($this->ARRaction as $K => $V) {
			$select = '';
		
			foreach ($ARR as $K2 => $V2) {
				if ($V['id'] == $V2['action_id']) {
					$select ='selected="selected"';
				}
				
			}
			
			$option .= '<option  '.$select.' value="'.$V['id'].'">'.$V['name'].'</option>';
		}
	
		return  '<select data-placeholder=" "  multiple="true" type="lastcat_'.$this->ARRitem['cat_id'].'" name="" id="'.$id.'">'.$option.'</select>
				';
	}
	
	public function renderProductImages($img , $id) {
		
		$line_img = '<div class="'.$id.'">';
		
		if ($img != '') {
			$arrimg = explode('|', $img);
				
			$C = 0;
			foreach($arrimg as $V ) {
				if ($V != ''){
					$line_img .= '
						<div class="one_preview_img_product float" id="img'.$C.'">
							<div class="one_preview_div_img"><img src="/uploads/81x84/'.$V.'" ></div>
							<span id="del'.$C.'" class="del"></span>
						</div>';
					$C++;
				}
			}
		}
		
		$line_img .= '<div class="float button_add_img"></div></div>';
		return $line_img;
	}
	
	
	
	public function renderFeatures($ARRfeatures, $ID) {
		
		$line_features = '<div class="message_type">Нет свойств</div>';
		foreach($ARRfeatures as $K => $feature) {
			if ($feature['admin'] == 0) $ARRfeatures2[] = $feature;
		}
		
		if (isset($ARRfeatures2)){
			$line_features = '';
			$count = count($ARRfeatures2);
			$i = 1;
			foreach($ARRfeatures2 as $K => $feature) {
				$feature_input = '';
				
						
						if ($feature['type'] == 'multiselect') {
							$feature_input = ''.$this->getToMultiSelect( explode('|', $feature['variants']), explode('|', $feature['value']), $ID.'_'.$feature['id'].'', $feature['name']).'';
						
						} elseif ($feature['type'] == 'select') {
							$feature_input = ''.$this->getToSelect( explode('|', $feature['variants']), explode('|', $feature['value']), $ID.'_'.$feature['id'].'', $feature['name']).'';
						
						} elseif ($feature['type'] == 'textarea') {
							$feature_input = '<textarea id="'.$ID.'_'.$feature['id'].'" >'.$feature['value'].'</textarea>';
						
						} elseif ($feature['type'] == 'text') {
							$feature_input .= '<input type="text" id="'.$ID.'_'.$feature['id'].'" value="'.$feature['value'].'">';
						
						} elseif ($feature['type'] == 'radio') {
							$feature_input .= ''.$this->getToRadioInput( explode('|', $feature['variants']), explode('|', $feature['value']), $ID.'_'.$feature['id'].'').'';
						
						}
					
					
					$line_features .= '
							'.(($feature['type'] == 'textarea') ? '<div class="absolute_left">' : '').'
								<div class="features_one '.(($i == $count) ? 'non_boder_features_one' : '').'">
									<div class="features_one_label">'.$feature['name'].'</div>
									<div class="features_one_input one_feature_category">'.$feature_input.'</div>
								</div>
							'.(($feature['type'] == 'textarea') ? '</div>' : '').'
						
				
						';
		
			$i++;
			}
		}
		return $line_features;
	}
	
	public function renderAdminFeatures($ARRfeatures, $ID) {
	
		$line_features = '<div class="message_type">Нет свойств</div>';
		foreach($ARRfeatures as $K => $feature) {
			if ($feature['admin'] == 1) $ARRfeatures2[] = $feature;
		}
		
		if (isset($ARRfeatures2)){
			$line_features = '';
			$count = count($ARRfeatures2);
			$i = 1;
			foreach($ARRfeatures2 as $K => $feature) {
				$feature_input = '';
				if ($feature['admin'] == 1){
		
					if ($feature['type'] == 'multiselect') {
						$feature_input = ''.$this->getToMultiSelect( explode('|', $feature['variants']), explode('|', $feature['value']), $ID.'_'.$feature['id'].'', $feature['name']).'';
		
					} elseif ($feature['type'] == 'select') {
						$feature_input = ''.$this->getToSelect( explode('|', $feature['variants']), explode('|', $feature['value']), $ID.'_'.$feature['id'].'', $feature['name']).'';
		
					} elseif ($feature['type'] == 'textarea') {
						$feature_input = '<textarea id="'.$ID.'_'.$feature['id'].'" >'.$feature['value'].'</textarea>';
		
					} elseif ($feature['type'] == 'text') {
						$feature_input .= '<input type="text" id="'.$ID.'_'.$feature['id'].'" value="'.$feature['value'].'">';
		
					} elseif ($feature['type'] == 'radio') {
						$feature_input .= ''.$this->getToRadioInput( explode('|', $feature['variants']), explode('|', $feature['value']), $ID.'_'.$feature['id'].'').'';
		
					}
				}
					
				$line_features .= '
							<div class="features_one '.(($i == $count) ? 'non_boder_features_one' : '').'">
								<div class="features_one_label">'.$feature['name'].'</div>
								<div class="features_one_input one_feature_category">'.$feature_input.'</div>
							</div>
					';
		
				$i++;
			}
		}
		
		return $line_features;
	}
	
	
	
	public function getToMultiSelect($ARRValues, $ARRselect, $id, $label) {
		$option = '';
		foreach ($ARRValues as $K => $V) {
			$select = '';
			foreach($ARRselect as $V2){
				if ($V == $V2) {
					$select ='selected="selected"';
				} 
			}
			$option .= '<option  '.$select.' value="'.$V.'">'.$V.'</option>';
		}
	
		return  '<select  class="multiselect" data-placeholder=" "  multiple="multiple" name="'.$id.'" id="'.$id.'">
				'.$option.'</select>
				';
	}
	
	public function getToSelect($ARRValues, $ARRselect, $id , $label) {
		$option = '';
		foreach ($ARRValues as $K => $V) {
			$select = '';
			foreach($ARRselect as $V2){
				if ($V == $V2) {
					$select ='selected="selected"';
				}
			}
			$option .= '<option  '.$select.' value="'.$V.'">'.$V.'</option>';
		}
	
		return  '<select  data-placeholder=" " name="" id="'.$id.'"><option  value="">Нет</option>'.$option.'</select>
				';
	}
	
	public function getCategorySelect($ARR) {
		$option = '';
		$check = false;
		
		
		$arrSelect = array();
		foreach ($ARR as $K => $V) {
			$select = '';
			foreach ( $this->ARRitem['categories'] as $K2 => $V2) {
				if ($V['id'] == $V2['id']) {
					$select ='selected="selected"';
					$check = true;
					$arrSelect[] = $V2['id'];
				}
			}
			$option .= '<option  '.$select.' value="'.$V['id'].'">'.$V['name'].'</option>';
		}
		if (!$check) {
			return  '<select  type="lastcat_'.implode(',', $arrSelect).'" data-placeholder=" " name="" id="change_category">
					<option selected="selected" value=" " >нет</option>
					'.$option.'
					</select>
				';
		} else {
			return  '<select class="multiselect" multiple="true"    type="lastcat_'.implode(',', $arrSelect).'" data-placeholder=" " name="" id="change_category">'.$option.'</select>
				';
		}
		
// 		$arrSelect = array();
// 		foreach ($ARR as $K => $VV) {
// 			$option .= '<optgroup label="'.$VV['name'].'">';
// 			foreach ($VV['options'] as $K => $V) {
// 				
// 			}
// 			$option .= '</optgroup>';
// 		}
	
// 		if (!$check) {
// 			return  '<select  type="lastcat_'.implode(',', $arrSelect).'" data-placeholder="Выберите Категорию" name="" id="change_category">
// 					<option selected="selected" value=" " >нет</option>
// 					'.$option.'
// 					</select>
// 				';
// 		} else {
// 			return  '<select class="multiselect" multiple="true"    type="lastcat_'.implode(',', $arrSelect).'" data-placeholder="Выберите Категорию" name="" id="change_category">'.$option.'</select>
// 				';
// 		}
		
	}
	
	public function getToRadioInput($ARRValues, $ARRselect, $id) {
		$option = '';
		foreach ($ARRValues as $K => $V) {
			$select = '';
			foreach($ARRselect as $V2){
				if ($V == $V2) {
					$select ='checked="checked"';
				}
			}
			$option .= '<div style="float:left; margin-right:10px;"><input  '.$select.' id="'.$id.'_'.$K.'" type="radio" name="'.$id.'" value="'.$V.'"><label for="'.$id.'_'.$K.'" >'.$V.'</label></div>';
		}
	
		return  $option.'<div class="br"></div>';
	}
	
	
	public function RenderOthersProducts($others) {
		
		$line_img = '<div class="product_others_block" id="'.((isset($others['id'])) ? 'others_products__'.$others['id'].'' : '').'">';
		if (isset($others['id'])) {
			
			$arrother = explode('|',$others['others']);

			foreach($arrother as $V ) {
				if ($V != ''){
					$arrV= explode(':', $V);
						
					$line_img .= '
							<div class="one_preview_other_img_products float "  id="other_'.$arrV[0].'">
								<div class="one_preview_div_img"><img src="'.$arrV[1].'"  height="84" ></div>
								<span id="del_'.$arrV[0].'" class="del" style="display: none;"></span>
							</div>';
						
				}
			}
		}
		return $line_img .= '<div class="button_add_other_product float"></div></div>';
	}
}