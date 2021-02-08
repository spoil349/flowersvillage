<?php
/**/
		ini_set('display_errors', '1');
		ini_set('display_startup_errors', '1');
		error_reporting(E_ALL);
		
		$query = Yii::app()->db->createCommand()
		->select('o.*, s.name as status_name')
		->from('orders as o,  orders_status as s')
		//->group('o.id')
		->limit(1)
		->order('id desc');
		
		$order = $query->queryALL();
		
		
		echo '<pre>';
		print_r($order);//exit;
		//print_r($products);
		exit;
		/**/
		$orderItems = explode('|',$order['products_id']);
		$orderProducts = array();
		foreach ($orderItems as $orderItemStr) {
			$orderItem = explode(':',$orderItemStr);
			$orderProducts[$orderItem[0]] = $orderItem;
			//0-id,1-sum,2-number
		}
		
		$content = 'Заказ №: '. $order['id']. PHP_EOL;
		$content .= 'Имя: '.$order['to_name']. PHP_EOL;
		$content .= 'Телефон: '.$order['to_phone']. PHP_EOL;
		$content .= 'Сумма: '.$order['price']. PHP_EOL;
		$content .= 'Комментарий: '.str_replace('<br>',PHP_EOL,$comment['price']). PHP_EOL;
		$content .= 'Состав: '. PHP_EOL;
		
		$chat_id = '-354451575';
		require 'vendor/autoload.php';
		$token = '1436034056:AAFyrdOTVhvNhWxnG1IXtPjeKKNAnQVd_ag';
		$telegram = new Telegram\Bot\Api($token);
		//$content = 'Состав:'. PHP_EOL .'1';
		$res = $telegram->sendMessage(
			$chat_id,//'chat_id'
			$content,//'text'
			true//disable_web_page_preview
		);
		echo '<pre>---1---';
		print_r($res->getMessageId());
		print_r($res);
		
		foreach ($products as $product) {
			$contentImg = 'Наименование: '.$product['name']. PHP_EOL;
			$contentImg .= 'Количество: '.$orderProducts[$product['id']][2].' шт'. PHP_EOL;
			$contentImg .= 'Стоимость: '.number_format($orderProducts[$product['id']][1], 0, ',', ' ' ).' р'. PHP_EOL;
			$imgArr = explode('|', $product['img']);
			if (count($imgArr) > 1) {
				$img = 'https://flowersvillage.ru/uploads/460x460/undefined/'.$imgArr[1];
				print_r($imgArr);
				$res = $telegram->sendPhoto(
					$chat_id,//'chat_id'
					$img,//'img'
					$contentImg//'caption'
				);
			} else {
				$res = $telegram->sendMessage(
					$chat_id,//'chat_id'
					$contentImg,//'text'
					true//disable_web_page_preview
				);
			}
			print_r($res);
		}
//<a href="https://t.me/something">&#8204;</a>