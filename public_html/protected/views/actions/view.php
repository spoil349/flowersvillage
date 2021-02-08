<style>
.any_bield { position: absolute; margin:0 !important;}
</style>
<div class="action_wrap">
	<div class="wrap_sizes  ">
		<div class="wrap_page">
		<div class="action_page wrap_block aloading"  style="margin-left:0;margin-right:0;padding:0; margin-top:30px; ">
				<img src="/uploads/<?php echo str_replace('|', '', $action['img'])?>">
				<div class="action_desc">
					<div class="action_desc_name"><?php echo $action['name']?></div>
					<div class="action_desc_title"><?php echo $action['title']?></div>
					<div class="action_desc_desc">
						<?php 
							$text =   preg_replace('/(^\r\n|\r|\n)\r\n|\r|\n(^\r\n|\r|\n)/is', '$1<br>$2', $action['description']);
							$text = preg_replace('/\r\n|\r|\n/is', '<br>', $text);
							echo $text;
						?>
					</div>
				</div>
				<div class="action_form">
					<form id="call" method="post">
						<div class="action_form_label">Заявка на обратный звонок</div>
						<input type="text" class="name" name="Call[name]" placeholder="Ваше имя">
						<input type="text" class="phone mask_input" name="Call[phone]" placeholder="Ваш телефон">
						<input type="submit" class="green_btn" value="Заказать звонок" type="submit">
						<div class="call_message"></div>
					</form>
				</div>
				<div class="br"></div>
		</div>
		
		
	</div>	
	
	</div>
	<div class="wrap_block resize_block   a_load_block ">
		<div id="products_line" class="products_line ">
			<?php $this->renderPartial('../catalog/items_line', array(
					'products' => $products,
					'sort' => false,
			));	?>
		</div>		
	</div>
	
</div>
	


