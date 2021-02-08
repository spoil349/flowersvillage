<style>
.wrap_block .any_bield { position: absolute; margin:0 !important;}
.wrap_block.other_block .any_bield { position: static; margin:0 !important;}
</style>

<div class="wrap_sizes wrap_item" style="position:relative;overflow: hidden;">
	<div class="navigation_item active">
	<?php if( isset($prev['id'])) :
		$Arrimg = explode('|', $prev['img']);
		$Arrimg = array_diff($Arrimg, array(''));
	?>
	
	<div id ="nav_prev_<?php echo $product['id']?>" class="prev_item nav_item">
		<a class="preview_item prev non" href="/catalog/<?php echo $prev['cat_uri']?>/<?php echo $prev['id']?>">
			<img src="/uploads/81x84/<?php echo current($Arrimg);?>" width="50">
			<span class="preview_item_name"><?php echo str_replace(' ', '&nbsp;', trim($prev['name']))?></span>
			<div class="preview_item_name_overlay"></div>
			<div class="preview_item_price item_price"><?php echo number_format( $prev['price'], 0, ',', ' ');?> <span class="b-rub">Р</span></div>
			<div class="item_prev">←</div>
			<div class="krutilka"></div>
			<div class="message_nav">Удобнее листать стрелками клавиатуры </div>
		</a>
	</div>
	<?php endif;?>
	<?php if (isset($next['id'])) :
		$Arrimg = explode('|', $next['img']);
		$Arrimg = array_diff($Arrimg, array(''));	
	?>
	<div id ="nav_next_<?php echo $product['id']?>" class="next_item nav_item">
		<a class="preview_item next non" href="/catalog/<?php echo $next['cat_uri']?>/<?php echo $next['id']?>">
			<img src="/uploads/81x84/<?php echo current($Arrimg);?>" width="50">
			<span class="preview_item_name"><?php echo str_replace(' ', '&nbsp;', trim($next['name']))?></span>
			<div class="preview_item_name_overlay"></div>
			<div class="preview_item_price item_price"><?php echo number_format( $next['price'], 0, ',', ' ' );?> <span class="b-rub">Р</span></div>
			<div class="item_next">→</div>
			<div class="krutilka"></div>
			<div class="message_nav right">Удобнее листать стрелками клавиатуры </div>
		</a>
	</div>
	<?php endif;?>
	<div class="br"></div>
	</div>
	<?php 
		$swipe =  (string)Yii::app()->request->cookies['swipe'];
		if ((int)$swipe != 1){
			echo '<div class="nav_item_mobile disable">Товары можно листать влево-вправо</div>';		
		}
	?>
	
	<div  id ="content_item_<?php echo $product['id']?>"  class="content_item <?php if(!Yii::app()->request->isPostRequest) echo 'item_def'?> " data-href="/catalog/<?php echo $product['cat_uri']?>/<?php echo $product['id']?>" data-title="<?php if (isset($product['meta_title']) &&  $product['meta_title'] != '') echo $product['meta_title']; else echo $product['name'];?>">
	<?php 
		$Arrimg = explode('|', $product['img']);
		$Arrimg = array_diff($Arrimg, array(''));
		 
		$big = '';
		$sm = '';
		$i = 1;
		foreach($Arrimg as $img){
			$big .= '<div class="'.(($i == 1) ? 'select '.((Yii::app()->request->isPostRequest) ? 'aloading' : '').'': '').'"><img id="big_'.$i.'" class="'.(($i == 1) ? 'select ': '').'" src="/uploads/460x460/'.$img.'" width="460"></div>';
		 	if (count($Arrimg) > 1)
		 		$sm .= '<div id="sm_'.$i.'" class="sm_one '.(($i == 1) ? 'select '.((Yii::app()->request->isPostRequest) ? '' : '').'': '').'"><img src="/uploads/100x100/'.$img.'" width="98"></div>';
		 	$i++;
		}
		$def_price = $product['price'];
		$line_feature_price ='';
		$pCheck = true;
		$fid = '';
		foreach($product['features_price'] as $K => $FP){
			if ($FP['price'] == $def_price && $pCheck) {
				$pCheck = false;
				$select = 'select';	
				$fid = $FP['id'];
			} else 
				$select = '';
			$line_feature_price .= '<span data-price="'.number_format( (int)$FP['price'], 0, ',', ' ' ).'" id="fprice_'.$FP['id'].'" class="blue fprice '.$select.'">'.$FP['value'].'</span>';
		}
	?>
	 <div class="item_block <?php if(!Yii::app()->request->isPostRequest) echo 'aloading'?>">
	 	<div class="item_block_galery ">
	 		<div class="galery_big">
	 			<?php echo $big ?>
	 			<div class="wrap_nav left disable">
	 				<div class="galery_nav l_nav"></div>
	 			</div>
	 			<div class="wrap_nav right <?php if ($sm == '') echo 'disable'?>">
	 			<div class="galery_nav r_nav"></div>
	 			</div>
	 		</div>
	 		<div class="galery_sm">
	 			<?php echo $sm ?>
	 			<div class="br"></div>
	 		</div>
	 	</div>
	 	<div class="item_block_desc">
	 		<h1 class="item_block_name"><?php echo $product['name']?></h1>
	 		<div class="item_block_price"><span><?php echo number_format( $product['price'], 0, ',', ' ' );?></span><?php echo Formats::getCountPrice($product['price'])?></div>
	 		<?php if ($line_feature_price != '') : ?>
	 			<div class="item_feature">
					<div class="item_feature_label"><?php echo $product['features_price_name']?></div>
					<?php echo $line_feature_price?>
				</div>
				
	 		<?php endif;?>
	 		<?php foreach($product['features'] as $fearure):?>
				<?php 
					if ($fearure['price'] != 1)
					$this->renderPartial('item_feature', array(
						'feature' => $fearure,
				));	?>
	 		<?php endforeach;?>	 	
	 			
	 			<div class="item_feature" style="position:relative;">
					<div class="item_feature_label">Количество</div>
					<div class="one_product_price_desc_input_count">
						<div class="one_product_input_count_minus count_minus"> − </div>
						<div class="one_product_input_count_input"><input class="number" style="padding:8px 0;" name="count" id="count_product" type="text" value="1"></div>
						<div class="one_product_input_count_plus count_plus"> + </div>
					</div>
					<?php if ($CheckCount == 1) :?>
						<div class="item_helper">Чтобы букет хорошо смотрелся,<br>выберите не меньше 7 роз</div>
					<?php endif ?>
				</div>
	 		<a class="addtocart green_btn" href="/catalog/add/<?php echo $product['id']?><?php if ($fid != '') echo '?fid='.$fid;?>"><span>Добавить в корзину</span></a>
	 		<a class="addtocart blue_btn" href="/catalog/add/<?php echo $product['id']?><?php if ($fid != '') echo '?fid='.$fid;?>" data-fastorder="2"><span>Заказ в один клик</span></a>
			
			<div class="payment_info hide">
				<ul class="payment_info_list">
					<li>Принимаем оплату картами <img src="/img/icon/cards_icon.svg" class="payment_info_icon"></li>
					<li>Доставляем по Кинелю</li>
					<li>Сделаем любой букет по фото на заказ</li>
					<li>Наличие на сегодня по <a class="blue" href="tel:+79967414590">+7 (996) 741-45-90</a></li>
				</ul>
			</div>
	 	</div>
	 	<div class="br"></div>
	</div>
	
	<div class="wrap_sizes recent_block <?php if(Yii::app()->request->isPostRequest) echo 'no_prog_load'?> ">
	<?php if (1) :?>	
	<?php if (count($products)> 0) :?>
		<div class="wrap_block resize_block bottom_products a_load_block fixed_height_one">
		<div class="block_label">За те же деньги</div>
			<div id="products_line" class="products_line ">
				<?php $this->renderPartial('../catalog/items_line', array(
						'products' => $products,
						'sort' => false,
				));	?>
			</div>		
		</div>
	<?php endif;?>
	<?php if (count($product['others']) > 0) :?>
 		
 				<div class="wrap_block  resize_block  bottom_products a_load_block fixed_height_one">
				<div class="block_label">С этим товаром покупают</div>
					<div id="products_line" class="products_line ">
						<?php $this->renderPartial('../catalog/items_line', array(
								'products' => $product['others'],
								'sort' => false,
						));	?>
					</div>
					<div class="br"></div>
				</div>
 		
 	<?php endif;?>
 	
 	<?php endif;?>	
	</div>
	</div>
	
	</div>