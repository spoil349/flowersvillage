<?php
class OneOrder extends CWidget
{


	public $htmlOptions =array();
	public $ARRorder =array();
	public $ARRstatus =array();
	public $ARRdelivery =array();
	public $ARRpayment =array();
	public $ARRpaid =array();
	
	
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
		echo $this->RenderOneOrder($this->ARRorder);
	}

	public function RenderOneOrder($order)
	{
// 		echo '<pre>';print_r($order);echo '</pre>';exit;
		if ($order['status'] == 'delete'){
			$label_line = '<span class="show_product">Восстановить заказ</span>';
//		} elseif ( $this->cat == 'new' && $this->order_id == 'new'){
// 			$label_line = '<div class="view_order_label">Новый Заказ</div>';
// 			$order['id'] = 'new';
		} else {
			$label_line = '<span class="green_buttons delete_order" style="color:#fff; width:100px;">Удалить заказ</span>';
		}
		
		return '<h1 id="order_'.$order['id'].'" type="'.$order['status'].'"> Заказ № '.$order['transaction_id'].'</h1>
				<div class="delete_show_product_block">
					'.$label_line.'
				</div>
				<div class="br"></div>
				'.$this->RenderDetails($order).'	
						
				';
	}
	//		'.$this->RenderDetails($order).'
	//				'.$this->RenderProducts($order).'
	
	public function RenderDetails($order)
	{

		return '<div class="view_order_details_date"> создан: <span>'.date('d-m-Y H:i:s',$order['create_time']).'</span> &nbsp;&nbsp;изменен: <span>'.$order['update_time'].'</span></div>
				<div class="block_label">Детали Заказа:</div>
		 		<div class="br"></div>
				<div class="features_one">
						<div class="features_one_label">Статус</div>
						<div class="features_one_input">'.$this->renderSelect($order['status'], $this->ARRstatus, 'order_status').'</div>
				</div>
				<div class="features_one">
						<div class="features_one_label">Статус оплаты <span style="font-weight:normal; color:#828282;">('.$this->ARRpaid[ (int)$order['paid']]['name'].')</span></div>
						<div class="features_one_input">'.$this->renderSelect($order['paid'], $this->ARRpaid, 'order_paid').'</div>
				</div>
				<div class="features_one">
 						<div class="features_one_label">Адрес</div>
 						<div class="features_one_input"><input type="text" name="order_address" id="order_address" value="'.$order['address'].'" placeholder=""></div>
 				</div>
 				<div class="features_one">
 						<div class="features_one_label">Описание</div>
 						<div class="features_one_input"><textarea id="order_comment" name="order_comment">'.$order['comment'].'</textarea></div>
 				</div>
 				<div class="features_one">
 						<div class="features_one_label">Дата/время доставки</div>
 						<div class="features_one_input"><input style="width:70px;" type="text" name="order_date" id="order_date" value="'.$order['date'].'" placeholder=""> <input style="width:40px;" type="text" name="order_time" id="order_time" value="'.$order['time'].'" placeholder=""></div>
 				</div>
 				<div class="features_one">
 						<div class="features_one_label"><input class="order_checkbox"type="checkbox" '.(($order['to_notice'] == 1)? 'checked="checked"' : '').' name="order_to_notice" id="order_to_notice" value="1"> Позвонить получателю перед доставкой и уточнить детали </div>
 				</div>
 				<div class="features_one">
 						<div class="features_one_label"><input class="order_checkbox" type="checkbox" '.(($order['picture'] == 1)? 'checked="checked"' : '').' name="order_picture" id="order_picture" value="1"> Сделать фотографию получателя в момент вручения букета и опубликовать фото на сайте </div>
 				</div>	
 				<div class="features_one">
 						<div class="features_one_label">Уведомление о доставке:</div>
 						<div class="chose_type_feature">
 							<div class="one_type">
 								<input class="order_checkbox" type="radio" name="order_from_notice" id="order_from_notice_no" '.(($order['from_notice'] == 'no') ? 'checked="checked"' : '').' value="no">
 								<label for="order_from_notice_no" >Нет</label>	
 							</div>
 							<div class="one_type">
 								<input class="order_checkbox" type="radio" name="order_from_notice" id="order_from_notice_sms" '.(($order['from_notice'] == 'sms') ? 'checked="checked"' : '').' value="sms">
 								<label for="order_from_notice_sms" >SMS</label>	
 							</div>
 							<div class="one_type">
 								<input class="order_checkbox" type="radio" name="order_from_notice" id="order_from_notice_call" '.(($order['from_notice'] == 'call') ? 'checked="checked"' : '').' value="call">
 								<label for="order_from_notice_call" >Звонок</label>	
 							</div>
 						<div class="br"></div>
 						</div>
 				</div>			
				<div class="features_one">
						<div class="features_one_label">Технический Комментарий (для Администратора)</div>
						<div class="features_one_input"><textarea id="order_admin_comment"  name="order_admin_comment">'.$order['admin_comment'].'</textarea></div>
				</div>
				<div class="block_label">Информация о получателе:</div>
		 		<div class="br"></div>
				<div class="features_one">
 						<div class="features_one_label"><input class="order_checkbox"type="checkbox" '.(($order['to_from'] == 1)? 'checked="checked"' : '').' name="order_to_from" id="order_to_from" value="1"> Отправитель является получателем</div>
 				</div>
				<div class="features_one">
 						<div class="features_one_label">Имя</div>
 						<div class="features_one_input"><input style="" type="text" name="order_to_name" id="order_to_name" value="'.(($order['to_from'] == 1 )? $order['from_name'] : $order['to_name']).'" placeholder=""></div>
 				</div>
 				<div class="features_one">
 						<div class="features_one_label">Телефон</div>
 						<div class="features_one_input"><input style="width:180px" type="text" name="order_to_phone" id="order_to_phone" value="'.(($order['to_from'] == 1 )? $order['from_phone'] : $order['from_name']).'" placeholder=""></div>
 				</div>
 				<div class="block_label">Информация об отправителе:</div>
		 		<div class="br"></div>
 				<div class="features_one">
 						<div class="features_one_label">Имя</div>
 						<div class="features_one_input"><input style="" type="text" name="order_from_name" id="order_from_name" value="'.$order['from_name'].'" placeholder=""></div>
 				</div>
 				<div class="features_one">
 						<div class="features_one_label">Телефон</div>
 						<div class="features_one_input"><input style="width:180px" type="text" name="order_from_phone" id="order_from_phone" value="'.$order['from_phone'].'" placeholder=""></div>
 				</div>
 				<div class="features_one">
 						<div class="features_one_label">Электронная почта</div>
 						<div class="features_one_input"><input style="width:180px" type="text" name="order_from_email" id="order_from_email" value="'.$order['from_email'].'" placeholder=""></div>
 				</div>			
 				'.$this->RenderProducts($order).'
		';
////
	}
	
	public function renderSelect($value_id, $ARR, $id)
	{
		$option = '';
		foreach ($ARR as $K => $V) {
			if ($V['uri'] == $value_id){ $select ='selected="selected"';} else {  $select ='';}
			$option .= '<option '.$select.' value="'.$V['uri'].'">'.$V['name'].'</option>';
		}
		
		return  '<select class="select" name="'.$id.'" id="'.$id.'">'.$option.'</select>';
	}
	
	public function RenderProducts($order)
	{
		
		$ArrProd = explode('|', $order['products_id']);
		
// 		echo '<pre>';
// 		print_r($ArrProd);
// 		echo '</pre>';

 		$line_where = array();
 		$newArrprod = array();
 		foreach ($ArrProd as  $prod) {
 			if ($prod != '') {
 			$Arrone = explode(':', $prod);

			$line_where[] = $Arrone[0];
			$newArrprod[$Arrone[0]]['id'] = $Arrone[0];
			$newArrprod[$Arrone[0]]['price'] = $Arrone[1];
			$newArrprod[$Arrone[0]]['size'] = $Arrone[2];
			if(isset($Arrone[3])){
				$newArrprod[$Arrone[0]]['description'] = $Arrone[3];
			} else 
				$newArrprod[$Arrone[0]]['description'] = '';
 			}
 		}
 		if (count($line_where) >= 1){
 			$sql = 'SELECT * FROM products p WHERE p.id IN ('.implode(', ', $line_where).') GROUP by p.id ';
 			$products = Yii::app()->db->createCommand($sql)->queryAll();
 		} else 
 			$products = array();	
 				
		$line_prod = '';
		$all_price = 0;
		$cat_id = 0;
 		foreach ($products as $V) {
			
			$ArrProd = explode('|', $order['products_id']);
			$select = false;

			foreach ($newArrprod as $prod) {

				if ($prod['id'] == $V['id']){
// 					$select = true;
					
					$Arrimg = explode('|', $V['img']);
					$Arrimg = array_diff($Arrimg, array(''));
					if (count($Arrimg) > 0)
						$img = '/uploads/81x84/'.current($Arrimg);
					else
						$img = '/uploads/81x84/default.jpg';
					
					$line_prod .= '
					<tr class="one_select_product" id="product'.$prod['price'].$V['id'].'" type="prod'.$V['id'].'" >
							<td id="product_img'.$prod['price'].$V['id'].'" class="one_select_product_name"><img src="'.$img.'"></td>
							<td id="product_name'.$prod['price'].$V['id'].'" class="one_select_product_name">'.$V['name'].'</td>
							<td id="product_price_one'.$prod['price'].$V['id'].'" class="one_select_product_price_one">'.number_format( $prod['price'], 0, ',', ' ' ).' р</td>
							<td id="product_quantity'.$prod['price'].$V['id'].'" class="one_select_product_quantity">'.$prod['size'].' шт</td>
							<td id="product_description'.$prod['price'].$V['id'].'" class="one_select_product_quantity">'.$prod['description'].'</td>
					</tr>';
					
				}		
			}
 		}
		
		return '<div class="block_label">Покупки:</div>
				<div class="view_order_products">
					<table cellspacing="0" cellpadding="0">
						<tbody>
						'.$line_prod.'
						</tbody>
					</table>
					<br><br>
					<div class="br"></div> 			
				</div>
				<div class="product_price" style="font-size:18px; font-weight:bold;">Сумма заказа: &nbsp; '.number_format( $order['price'], 0, ',', ' ' ).' рублей </span> </div>
						
		';
		
// 		<div class="product_discount" style="">
// 		<div class="one_discount_label">Скидка:</div>
// 		<div class="one_discount_input"><input name="discount" type="text"  onkeyup ="this.value=parseInt(this.value) | 0" id="discount'.$order['id'].'" value="'.$order['discount'].'" placeholder="0">&nbsp;%</div>
// 		<div class="br"></div>
// 		</div>
// 		<div class="br"></div>
// 		<div class="product_allprice" style="">Итого: &nbsp;<span>'.$order['discount_price'].' рублей</span></div>
	}
}