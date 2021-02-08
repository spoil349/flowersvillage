<?php

class OneSection extends CWidget
{
	
	
	public $ARRsection = array();
	
	
	public function run()
	{
		//echo '<div  style="margin:0 0 10px 5px;font-size:14px; color:#4cb86f; font-weight:bold;">Кликните двойным щелчком чтобы редактировать поле!</div>';
		echo '<div class="edit_category" style="width:100%;">';
		echo $this->RenderRow($this->ARRsection);
		echo '</div>';
	}
	
	public function RenderRow($section){
// 			echo '<pre>';
// 			print_r($section);
// 			echo '</pre>';
		
			return '
				<h1 id="section_'.$section['id'].'" type="'.$section['uri'].'"> Категория: <input id="name__'.$section['id'].'" class="section_field" type="text" value="'.$section['name'].'"></h1>
				<div class="delete_show_category_block">
					<span style="width:120px;" class="green_buttons show_section '.(($section['visibly'] == 0) ? 'no_visibly' : '').'">'.(($section['visibly'] == 0) ? 'Показать' : 'Скрыть').' категорию</span>
					<span style="width:120px;" class="green_buttons delete_section '.(((int)$section['count_poduct'] > 0)? 'used_section" id="count_'.$section['count_poduct'].'' : '').'">Удалить категорию</span>
				</div>
				<div class="edit_category_left">
					<div class="features_one non_boder_features_one">
							<label style="display:inline-block; margin-bottom:20px; margin-left:-20px;" >Адрес (ENG)</label>
							<div class="features_one_input"><input class="section_field" id="uri__'.$section['id'].'" type="text" value="'.$section['uri'].'" ></div>
					</div>
				</div>
				<div class="br"></div>			
			';

	}
	
	public function getToMultiSelectFeatures($ARRselect, $id) {
		$option = '';
		foreach ($this->ARRFeatures as $K => $V) {
			$select = '';
			foreach($ARRselect as $V2){
				if ($V['id'] == $V2['feature_id'] &&  $V2['visibly'] == 1) {
					$select ='selected="selected"';
				}
			}
			if ($V['tocart'] != 1) $option .= '<option  '.$select.' value="'.$V['id'].'">'.$V['name'].'</option>';
		}
	
 		return  '<select class="multiselect" data-placeholder="Выберите Свойство"  multiple="true" name="" id="'.$id.'">'.$option.'</select>
 				';
	}
	public function getToMultiSelectActions($ARRselect, $id) {
		$option = '';
		foreach ($this->ARRActions as $K => $V) {
			$select = '';
			foreach($ARRselect as $V2){
				if ($V['id'] == $V2['action_id'] &&  $V2['visibly'] == 1) {
					$select ='selected="selected"';
				}
			}
			$option .= '<option  '.$select.' value="'.$V['id'].'">'.$V['name'].'</option>';
		}
	
		return  '<select class="multiselect" data-placeholder="Выберите Свойство"  multiple="true" name="" id="'.$id.'">'.$option.'</select>
 				';
	}
	
	
}
	

//