<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SendToMail {

	private function AddEmailClass() {
		require("protected/extensions/phpmailer/class.phpmailer.php");
		require_once('protected/extensions/transport/transport.php');
	}
	
	public function SendMail($to , $body, $subject, $from, $from_name, $PathToFile = '', $file = '') {
			
		
	
// 		$mail = new PHPMailer();
// 		$mail->IsSMTP();
// 		$mail->SMTPAuth = true;
// 		$mail->CharSet = "utf-8";                               // set mailer to use SMTP
// 		$mail->SMTPDebug = false;
// 		$mail->SMTPSecure = 'ssl';
// 		$mail->Host = Yii::app()->params['smtp_host'];
// 		$mail->Port = Yii::app()->params['smtp_port'];   // specify main and backup server
// 		$mail->Username = Yii::app()->params['smtp_username'];  // SMTP username
// 		$mail->Password = Yii::app()->params['smtp_password']; // SMTP password
// 		$mail->IsHTML(true);

// 		if ($PathToFile!= '' && $file != '')	$mail->AddAttachment($PathToFile,$file);
		
// 		$mail->SetFrom(Yii::app()->params['smtp_username'], $from_name);
// 		$mail->AddAddress($to);
// 		$mail->Subject = $subject;
// 		$mail->Body    = $body;
			
// 		if(!$mail->Send()) {
// 			return false;
				
// 		} else {return true;}

		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers .= 'From: '.$from_name.' <shny0990@gmail.com>' . "\r\n";
		
		mail($to, $subject, $body, $headers);//, '-fnoreply@artcream.ru'

	    
	}
	private function SendSMS($params) {
		$smsApi = new Transport();
		$phones = Yii::app()->params['toPhone'];
		$send = $smsApi->send($params,$phones);
		
		/*
		$params = array(
				'action'=>'send', // принимает значения 'send' (отправить СМС, выбрано по-умолчанию) или 'check' (только проверить возможность оптравки);
				#'datetime'=>'', // дата и время отправки смс в формате (ГГГГ-ММ-ДД ЧЧ:ММ:СС);
				'source'=>'Art Cream', // имя отправителя;
				'onlydelivery'=>1, // (по-умолчанию 0 — платить за все смски, можно задать 1 — платить только за доставленные);
				#'regionalTime'=>'', // (по-умолчанию 0 — отправлять по вашему местному времени, можно задать 1 — отправлять по местному времени абонента);
				'stop'=>0, // (по-умолчанию 1 — не отправлять абонентам, находящимся в Стоп-листах);
				#'smsid'=>'', // желаемый id смски.
				'text'=>'',
				//'text' => 'test',
		);
		*/
	}
	
	
	
	
	public function SendPreview($ARRfield){
		
		$body = '<body style="color:#333333; font-family:arial; font-size:14px;">
							<h1 style="color:#78c028;">Флау-вил</h1>
							<p style="width:50%; margin:10px 0; height:1px; background-color:#999999"></p>
							<h2 style="font-weight:bold;">Новый отзыв</h2>
							<br>
							Отзыв отправил:  <b>'.$ARRfield['name'].'</b>
							<br><br>
						 	Сообщение:  <b>'.$ARRfield['review'].'</b>
							<br>
							</body>
			';
		
		$header = 'Отзыв с сайта Флау-вил';
		
		$this->AddEmailClass();
		$this->SendMail(implode(', ', Yii::app()->params['toEmail']), $body, $header,  '', 'Flau-Vil', $ARRfield['path'], $ARRfield['img']);
	}
	
	public function SendCall($ARRfield){
	
		
		$params = array(
				'action'=>'send',
				'source'=>'Art Cream',
				'onlydelivery'=>1,
				'stop'=>0,
				'text'=>'Заказ звонка! '.$ARRfield['name'].' т.:'.$ARRfield['phone'].'',
		);
		
		$body = '<body style="color:#333333; font-family:arial; font-size:14px;">
							<h1 style="color:#78c028;">Флау-вил</h1>
							<p style="width:50%; margin:10px 0; height:1px; background-color:#999999"></p>
							<h2 style="font-weight:bold;">Заказ звонка </h2>
							<br>
							Отзыв отправил:  <b>'.$ARRfield['name'].'</b>
							<br><br>
						 	Телефон:  <b>'.$ARRfield['phone'].'</b>
							<br>
							</body>
			';
	
		$header = 'Заказ звонка с сайта  Флау-вил';
	
		$this->AddEmailClass();
		$this->SendMail(implode(', ', Yii::app()->params['toEmail']), $body, $header,  '', 'Flau-vil');
		
	}
	
	public function SendOrdertoAdmin($ARRfield){
		
		 $params = array(
		 		'action'=>'send',
		 		'source'=>'Art Cream',
		 		'onlydelivery'=>1,
		 		'stop'=>0,
		 		'text'=>'Новый Заказ №'.$ARRfield['id'].'! '.$ARRfield['table_product_mob'].'; '.$ARRfield['to_name'].', тел:'.$ARRfield['to_phone'].'',
		 );
		
		$body = '<body style="color:#333333; font-family:arial; font-size:14px;">
							<h1 style="color:#78c028;">Флау-вил</h1>
							<p style="width:50%; margin:10px 0; height:1px; background-color:#999999"></p>
							<h2 style="font-weight:bold;">Новый Заказ № '.$ARRfield['id'].'</h2>
							<br><br>								
							<h5>Отправитель</h5>		
							
								Имя:  <b>'.$ARRfield['to_name'].'</b>
								<br>
								тел.:  <b>'.$ARRfield['to_phone'].'</b>		
								'.$ARRfield['comment'].'
							<h5>Заказ:</h5>
								'.$ARRfield['table_product'].'
							<br><br>
							Итого:  <b style="font-size:16px;">'.number_format( $ARRfield['price'], 0, ',', ' ' ).' рублей</b>
							<br><br>			
							<p style="width:100%; margin:20px 0; height:1px; background-color:#999999"></p>
							<span style="color:#888888;font-size:13px;">Интернет-магазин &ndash; <a tyle="color:#333333;" href="http://flowersvillage.ru/">Флау-вил</a>
							<br>
							</body>
			';
	
		$header = 'Заказ с сайта  Флау-вил';
		$this->SendMail(implode(', ', Yii::app()->params['toEmail']), $body, $header, '', 'Flau-vil');
	}
	
	
	public function SendOrdertoUser($ARRfield){
		
				
		$body = '<body style="color:#333333; font-family:arial; font-size:13px;">
							<h1 style="color:#78c028;">Флау-вил</h1>
							<p style="width:50%; margin:10px 0; height:1px; background-color:#999999"></p>
							<h2 style="font-weight:bold;">Заказ № '.$ARRfield['id'].'</h2>
							<br><br>
							Мы скоро свяжемся с вами, чтобы согласовать время доставки.
							<br><br>
							<h5>Получатель</h5>										
							
							Имя:  <b>'.$ARRfield['to_name'].'</b>
							<br>
							тел.:  <b>'.$ARRfield['to_phone'].'</b>		

							<h5>Ваш заказ:</h5>
							
								'.$ARRfield['table_product'].'
							<br>
							Итого:  <b style="font-size:16px;">'.number_format( $ARRfield['price'], 0, ',', ' ' ).' рублей
							
							<br><br>		
							<p style="width:100%; margin:20px 0; height:1px; background-color:#999999"></p>
							<span style="color:#888888;font-size:13px;">Интернет-магазин &ndash; <a tyle="color:#333333;" href="http://flowersvillage.ru/">Флау-вил</a>
							<br>
							</body>
		';
	
		$header = 'Заказ с сайта  Флау-вил';
		
		if(filter_var($ARRfield['from_email'], FILTER_VALIDATE_EMAIL)){ 
			$this->SendMail($ARRfield['from_email'],  $body, $header,  '', 'Flau-vil');
		}
	}
	
	public function SendPaidOrdertoAdmin($ARRfield){
	
		require_once('protected/extensions/transport/transport.php');
	
		$params = array(
				'action'=>'send',
				'source'=>'Art Cream',
				'onlydelivery'=>1,
				'stop'=>0,
				'text'=>'Заказ №'.$ARRfield['id'].'! '.(($ARRfield['paid'] == 1 || $ARRfield['paid'] == '1')? 'оплачен' : 'неоплачен').' Сумма: '.$ARRfield['price'].' рублей',
		);
	
		$body = '<body style="color:#333333; font-family:arial; font-size:14px;">
							<h1 style="color:#78c028;">Флау-вил</h1>
							<p style="width:50%; margin:10px 0; height:1px; background-color:#999999"></p>
							<h2 style="font-weight:bold;">Оплата Заказа № '.$ARRfield['id'].'</h2>
							<br>
							Заказ №:  <b>'.$ARRfield['id'].'</b>
							<br><br>
							Статус оплаты:  <b>'.(($ARRfield['paid'] == 1 || $ARRfield['paid'] == '1' )? 'оплачен' : 'неоплачен').'</b>
							<br><br>
							Сумма:  <b style="font-size:16px;">'.number_format( $ARRfield['price'], 0, ',', ' ' ).' рублей</b>
							<br>
							<p style="width:100%; margin:20px 0; height:1px; background-color:#999999"></p>
							<span style="color:#888888;font-size:13px;">Интернет-магазин &ndash; <a tyle="color:#333333;" href="http://flowersvillage.ru/">Цвет`Оk</a>
							<br>
							</body>
			';
	
		$header = 'Оплата Заказа № '.$ARRfield['id'].'';
		$this->AddEmailClass();
		$this->SendMail(Yii::app()->params['toEmail'], $body, $header,  '', 'Flau-vil');
	}
	
	
	public function SendOrder($order){
	
		$ArrProd = explode('|', $order['products_id']);
		$line_where = array();
		$newArrprod = array();
		$i = 0;
		foreach ($ArrProd as  $prod) {
			$Arrone = explode(':', $prod);
			$line_where[] = $Arrone[0];
			$newArrprod[$i]['id'] = $Arrone[0];
			$newArrprod[$i]['price'] = $Arrone[1];
			$newArrprod[$i]['count'] = $Arrone[2];
			$newArrprod[$i]['fid'] = $Arrone[3];
			$i++;
		}
		if (count($line_where) > 0){
			$sql = 'SELECT p.*
			, c.uri as cat_uri FROM products p INNER JOIN products_category pc ON pc.product_id = p.id INNER JOIN categories c ON c.id = pc.category_id 
			WHERE p.id IN ('.implode(', ', $line_where).') GROUP by p.id ';
			$products = Yii::app()->db->createCommand($sql)->queryAll();
			
			$sql = 'SELECT * FROM feature_product_price WHERE product_id IN ('.implode(', ', $line_where).') GROUP by id ';
			$FidPrice = Yii::app()->db->createCommand($sql)->queryAll();
			$productsFidPrice = array();
			foreach ($FidPrice as $fid) {
				$productsFidPrice[$fid['id']] = $fid;
			}
		} else
			$products = array();
		
		$line_prod = '';
		$line_prod_mob = '';
		$all_price = 0;
		$cat_id = 0;
		$i = 0;
		foreach ($products as $V) {
				
			$ArrProd = explode('|', $order['products_id']);
			$select = false;
		
			foreach ($newArrprod as $prod) {
		
				if ($prod['id'] == $V['id']){
					// 					$select = true;
						
					$Arrimg = explode('|', $V['img']);
					$Arrimg = array_diff($Arrimg, array(''));
					if (count($Arrimg) > 0)
						$img = 'http://flowersvillage.ru/uploads/81x84'.current($Arrimg);
					else
						$img = '';
					
					$style = '';
					if ($i == 0) {
						$style = '';
						$i == 1;
					} elseif ($i == 1){
						$style = 'background-color:#ccc";';
						$i == 0;
					}	
					$feature_type = '';
					if (isset($productsFidPrice[$prod['fid']])) {
						$feature_type = '('.$productsFidPrice[$prod['fid']]['value'].')';
					}
					
					$line_prod_mob .= ','.$V['name'].' - '.number_format( $prod['price'], 0, ',', ' ' ).' р';
					$line_prod .= '
					<tr style="'.$style.'" class="one_select_product" id="product'.$prod['price'].$V['id'].'" type="prod'.$V['id'].'" >
							<td id="product_img'.$prod['price'].$V['id'].'" class="one_select_product_name"><img src="'.$img.'" width="50"></td>
							<td id="product_name'.$prod['price'].$V['id'].'" class="one_select_product_name"><a href="http://flowersvillage.ru/catalog/'.$V['cat_uri'].'/'.$V['id'].'">'.$V['name'].'</a></td>
							<td id="product_price_one'.$prod['price'].$V['id'].'" class="one_select_product_price_one">'.number_format( $prod['price'], 0, ',', ' ' ).' рублей '.$feature_type.'</td>
							<td id="product_quantity'.$prod['price'].$V['id'].'" class="one_select_product_quantity">'.$prod['count'].' шт</td>
					</tr>';
						
				}
			}
		}
		$ARRfield['id'] = $order['id'];
		$ARRfield['to_name'] = $order['to_name'];
		$ARRfield['price'] = $order['price'];
		$ARRfield['to_phone'] = $order['to_phone'];
		$ARRfield['products_id'] = $order['products_id'];
		$ARRfield['comment'] = $order['comment'];
		$ARRfield['table_product_mob'] = $line_prod_mob;
		
		$ARRfield['table_product'] = '<table cellspacing="0" cellpadding="1" style="width:50%;">
						<tbody>
						'.$line_prod.'
						</tbody>
					</table>
		';
		
		$this->AddEmailClass();
		//$this->SendOrdertoUser($ARRfield);
		$this->SendOrdertoAdmin($ARRfield);
		$this->SendTg($order, $products);
	}
	
	public function Html2Pdf($content){
	
		require_once('protected/html2pdf/html2pdf.class.php');
		$html2pdf = new HTML2PDF('P','A4','en', true, 'utf-8');
 		$html2pdf->pdf->SetFont('freesans', '', 9);
		$html2pdf->writeHTML(iconv("WINDOWS-1251","UTF-8", $content ));  
		$html2pdf->Output($_SERVER['DOCUMENT_ROOT'].'/uploads/2.pdf');
		
	}
	
	public function SendTg($order, $products) {
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
		$content .= 'Сумма: '.number_format($order['price'], 0, ',', ' ' ).' р'. PHP_EOL;
		$content .= str_replace('<br>',PHP_EOL,$order['comment']);
		$content .= 'Состав: '. PHP_EOL;
		
		$chat_id = '-1001207810416';
		require 'vendor/autoload.php';
		$token = '1436034056:AAFyrdOTVhvNhWxnG1IXtPjeKKNAnQVd_ag';
		$telegram = new Telegram\Bot\Api($token);
		
		$res = $telegram->sendMessage(
			$chat_id,//'chat_id'
			$content,//'text'
			true//disable_web_page_preview
		);
		
		$messageId = $res->getMessageId();
		
		foreach ($products as $product) {
			$contentImg = 'Наименование: '.$product['name']. PHP_EOL;
			$contentImg .= 'Количество: '.$orderProducts[$product['id']][2].' шт'. PHP_EOL;
			$contentImg .= 'Цена: '.number_format($orderProducts[$product['id']][1], 0, ',', ' ' ).' р'. PHP_EOL;
			$contentImg .= 'Ссылка: https://flowersvillage.ru/catalog/'.$product['cat_uri'].'/'.$product['id'];
			$imgArr = explode('|', $product['img']);
			if (count($imgArr) > 1) {
				$img = 'https://flowersvillage.ru/uploads/460x460'.$imgArr[1];
				$res = $telegram->sendPhoto(
					$chat_id,//'chat_id'
					$img,//'img'
					$contentImg,//'caption'
					$messageId
				);
			} else {
				$res = $telegram->sendMessage(
					$chat_id,//'chat_id'
					$contentImg,//'text'
					true,//disable_web_page_preview
					$messageId
				);
			}
		}
	}
}
