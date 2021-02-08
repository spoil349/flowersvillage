<?php

class OrderController extends Controller
{

	public $layout = 'main';
	
	
	public function actionIndex()
	{
		if(!Yii::app()->request->isPostRequest || !isset($_POST['Order']) || (string)Yii::app()->request->cookies['cart'] == '')
			throw new CHttpException(404,'Страница не найдена');
		$p = new CHtmlPurifier;
			
		$cart = (string)Yii::app()->request->cookies['cart'];
		$ARR_products = explode('|', $cart);
		$price = 0;
		foreach($ARR_products as $K => $product) {
			$Arrone = explode(':', $product);
			
			$price += (int)$Arrone[1] * (int)$Arrone[2];
		}
		
		$Order = $_POST['Order'];
		
		$name = 
		$phone = $p->purify($Order['phone']);
		
		$order = new Order();
		
		$order->date = date('Y.m.d') ;
		$order->time = date('H:i') ;
		$order->create_time = time();
		$order->to_name  = $p->purify($Order['name']);
		$order->to_phone  = $p->purify($Order['phone']);
		$order->products_id = $cart;
		$order->price = $price;
		$order->discount_price = $price;
		$comment = '';
		if (!empty($Order['delivery_type'])) {
			$comment .= 'Тип доставки: '.$Order['delivery_type'].'<br>';
		}
		if (!empty($Order['delivery_address'])) {
			$comment .= 'Адрес доставки: '.$Order['delivery_address'].'<br>';
		}
		if (!empty($Order['pay_type'])) {
			$comment .= 'Оплата: '.$Order['pay_type'].'<br>';
		}
		if (!empty($Order['postcard'])) {
			$comment .= 'Текст для открытки: '.$Order['postcard'].'<br>';
		}
		if (!empty($comment)) {
			$order->comment = $comment;
		}
		
		if ($order->save()){
			Yii::app()->request->cookies['cart'] = new CHttpCookie('cart', '');
			$mail = new SendToMail();
			$mail->SendOrder($order);	
				echo CJSON::encode(array(
						'error' => 0,
						'id'=> $order->id,
						'message' =>'<span class="success">Заказ оформлен!</span> Мы скоро позвоним вам, чтобы обговорить детали',
						//'message' =>'<span class="error">Ошибка оформления, <a href="#" id="resend"  class="gray">повторить попытку<a>.</span>',
				));
			
		} else {
			echo CJSON::encode(array(
					'error' => 1,
					'id'=> 0,
					'message' =>'<span class="error">Ошибка оформления, <a href="#" id="resend" class="gray">повторить попытку<a>.</span>',
			));
		}
		
	}
	
	
}