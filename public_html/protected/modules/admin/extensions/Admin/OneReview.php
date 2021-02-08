<?php
class OneReview extends CWidget
{


	public $htmlOptions =array();
	public $ARRitem =array();

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
		echo $this->RenderOneProduct($this->ARRitem);
	}

	public function RenderOneProduct($review) {
	
		return'
				<h1 id="reviews_'.$review['id'].'" > Отзыв от <input id="name__'.$review['id'].'" class="review_field" type="text" value="'.$review['name'].'"></h1>
				<div class="delete_show_product_block">
					<span style="width:100px;" class="green_buttons show_product '.(($review['visibly'] == 0) ? 'no_visibly' : '').'">'.(($review['visibly'] == 0) ? 'Показать' : 'Скрыть').' отзыв</span>
					<span style="width:100px;" class=" green_buttons delete_product">Удалить отзыв</span>
				</div>
				<div class="features_one">
						<div class="features_one_label">Должность</div>
						<div class="features_one_input"><input class="review_field" type="text" name="spec" id="spec__'.$review['id'].'" value="'.$review['spec'].'"></div>
				</div>
				<div class="features_one non_boder_features_one">
						<div class="features_one_label ">Фотография</div>
						<div id="img_'.$review['id'].'" class="img_block" style="width:100px;height:100px; border:1px solid #888; border-radius:4px; text-align:center;">
							<img src="'.(($review['img'] != '')? '/uploads/100x100/'.$review['img'].'' : '').'" width="" height="100" width="100">	
						</div>
						<div style="margin-top:10px; width:100px; text-align:center;" class="add_img green_buttons">'.(($review['img'] == '')? 'Добавить' : 'Изменить').'</div>
						<input type="file" id="img_input" style="display:none;" >
				</div>	
				<div class="features_one non_boder_features_one">
						<div class="features_one_label ">Текст сообщениея</div>
						<div class="features_one_input"><textarea class="review_field"   name="text" id="text__'.$review['id'].'"  >'.$review['text'].'</textarea></div>
				</div>
								
			';
			
	
	} 
	
}