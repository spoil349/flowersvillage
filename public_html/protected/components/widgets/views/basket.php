<div class="basket <?php if ($aloading) echo 'aloading' ?> <?php if(count($products) < 1) echo 'empty'?>">
	<a title="Вернуться в корзину" class="return_cart" data-nav="prev"><span>Назад</span><b class="del">←</b></a>
	<div class="wrap_sizes">
		<form id="order"  action="/order" method="post">
			<div class="success_form basket_step" data-step="0">
				<p></p>
				<a href="/catalog/delall" title="Закрыть корзину" class="basket_clear close"><b class="del">×</b></a>
			</div>
			
			<div class="basket_cart basket_step _active" data-step="1">
			<?php 
			$all_price = 0;
			$all_count  =count($products);
			foreach ($products as $product) {
				
				$all_price +=(int)$product['price'] * (int)$product['count'];
			}?>
				<div class="basket_poduct">
				<?php 
			
				
				foreach ($products as $product) :
					$Arrimg = array();
					
					$Arrimg = explode('|', $product['img']);
					$Arrimg = array_diff($Arrimg, array(''));
				?>		
					<div class="preview_item " id="pr<?php echo $product['id'].$product['fid']?>">
						<img src="/uploads/81x84/<?php echo current($Arrimg);?>" width="50">
						<div class="preview_item_name"><a href="/catalog/<?php echo $product['cat_uri']?>/<?php echo $product['id']?>" class="blue "><?php echo str_replace(' ', '&nbsp;', trim($product['name']))?></a></div>
						<div class="preview_item_name_overlay"></div>
						<div class="preview_item_price item_price"><?php echo number_format( $product['price'], 0, ',', ' ' );?> <span class="b-rub">Р</span><?php  echo ', '.$product['count'].' шт'?></div>
						<a href="/catalog/delete/<?php echo $product['id']?>"  alt="удалить из корзины" class="non basket_item_del">×</a>
					</div>
				<?php endforeach;?>
					
					<div class="br"></div>
				</div>
				<div class="basket_order ">
					<a style="display:block;" class="buy_order green_btn" data-nav="next">Заказать...</a>
					<div class="basket_order_label">В&nbsp;корзине&nbsp;<?php echo $all_count?>&nbsp;<?php echo Formats::getCountProducts($all_count)?> на&nbsp;сумму&nbsp;<span><?php echo str_replace(' ', '&nbsp;', number_format( $all_price, 0, ',', ' ' ));?>&nbsp;рублей</span></div>
				</div>
				<a href="/catalog/delall" title="Очистить корзину" class="basket_clear"><span>Очистить корзину</span><b class="del">×</b></a>
				<div class="br"></div>
			</div>
			<div class="confirm_form basket_step" data-step="2">
				<input name="Order[name]" type="text" class="requred" placeholder="Ваше имя" maxlength ="50"></input>
				<input name="Order[phone]" type="tel" class="requred phone mask_input" placeholder="Ваш телефон"></input>
				<a class="green_btn big" data-nav="next">Далее</a>
				<div class="progress_send krutilka"></div>
				<!--<a href="/catalog/delall" title="Вернуться в корзину" class=" return_cart"><span>Вернуться в корзину</span><b class="del">&darr;</b></a>-->
			</div>
			
			<div class="basket_step" data-step="3">
				<span class="basket_title">Укажите адрес доставки или &laquo;Самовывоз&raquo;</span>
				<div class="form_block">
					<div class="formField">
						<input id="delivery_type_pickup" type="radio" name="Order[delivery_type]" value="Самовывоз" checked>
						<label for="delivery_type_pickup">Самовывоз</label>
					</div>
					<div class="formField">
						<input id="delivery_type_delivery" type="radio" name="Order[delivery_type]" value="Доставка" >
						<label for="delivery_type_delivery">Доставка</label>
						<textarea name="Order[delivery_address]" value="" placeholder="Адрес"></textarea>
					</div>
				</div>
				<a class="green_btn big" data-nav="next">Далее</a>
			</div>
			<div class="basket_step" data-step="4">
				<span class="basket_title">Оплата</span>
				<div class="form_block">
					<div class="formField">
						<input id="pay_type_cash" type="radio" name="Order[pay_type]" value="Наличными при получении" checked>
						<label for="pay_type_cash">Наличными при получении</label>
					</div>
					<div class="formField">
						<input id="pay_type_remittance" type="radio" name="Order[pay_type]" value="Переводом на карту">
						<label for="pay_type_remittance">Переводом на карту</label>
					</div>
				</div>
				<a class="green_btn big" data-nav="next">Далее</a>
			</div>
			<div class="basket_step" data-step="5">
				<span class="basket_title">Если потребуется открытка или записка, введите текст для получения</span>
				<div class="form_block">
					<div class="formField">
						<textarea name="Order[postcard]" value="" placeholder="Текст послания"></textarea>
					</div>
				</div>
				<a class="green_btn confirm_btn">Отправить заказ</a>
			</div>
		</form>
	</div>
</div>	