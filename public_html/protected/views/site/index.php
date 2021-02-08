<style>
.any_bield { position: absolute; margin:0 !important;}
</style>

<?php if (0) : ?>
	<div class="wrap_sizes" style="overflow:hidden;">
		<div  class="h_fotorama aloading" data-fit="cover" data-transition="slide" data-height="400" style="">
			<img src="/img/avd_1.jpg">
			<img src="/img/avd_2.jpg">
		</div>
	</div>

	<script>
		$(function(){
			var posY = -1;
			var posX = -1;
			$('body').on('mousedown', '.h_fotorama img', function(e){
				posY = e.clientY;
				posX = e.clientX;
				console.log(posY+' '+posX);
			})
	
			$('body').on('mouseup', function(e){
				if (posY > e.clientY - 20 && posY < e.clientY + 20 && posX > e.clientX - 20 && posX < e.clientX + 20){
						location.href = 'http://google.com';
					}	
					
			})
		})
	</script>
<?php endif;?>


<div class="promo">
	<div class="promo_column">
		<div  href="<?php echo $actions[0]['link']?>" class="one_promo aloading one_promo1" >
			<img src="/img/promo_desc_bg.gif" width="10" height="10" style="opacity:0; position:absolute; top:-50px; z-index:-1;">
			<?php 
				$Arr1 = explode('|', $actions[0]['preview']);
				$Arr1 = array_diff($Arr1, array(''));
				$i = 1;
				foreach ($Arr1 as $k => $V){
					echo '<img id="1_'.$i.'" src="/uploads/'.$V.'" width="460" height="452">';
					$i++;
				}
			?>
			
			<div class="promo_desc <?php if($actions[0]['plashka'] == 1) echo 'green'?>">
				<?php if ($actions[0]['name'] != '') :?>
					<div class="promo_desc_name"><a class="white" href="<?php echo $actions[0]['link']?>"><?php echo $actions[0]['name']?></a></div>
				<?php else :?>
					<div style="display:none !important;" class="promo_desc_name"><a class="white" href="<?php echo $actions[0]['link']?>"></a></div>
				<?php endif;?>
				
				<?php if ($actions[0]['title'] != '') :?>
					<div class="promo_desc_text"><?php echo $actions[0]['title']?></div>
				<?php endif;?>
			</div>
		</div>
	</div>
	<div class="sep_vert"></div>
	<div class="promo_column">
		<div class="one_promo aloading sm_hor1">
			<img src="/img/promo_desc_bg.gif" width="10" height="10" style="opacity:0; position:absolute; top:-50px; z-index:-1;">
			<?php 
				$Arr1 = explode('|', $actions[1]['preview']);
				$Arr1 = array_diff($Arr1, array(''));
				$i = 1;
				foreach ($Arr1 as $k => $V){
					echo '<img id="1_'.$i.'" src="/uploads/'.$V.'"  width="460" height="224">';
					$i++;
				}
			?>
	
			<div class="promo_desc <?php if($actions[1]['plashka'] == 1) echo 'green'?>">
				<?php if ($actions[1]['name'] != '') :?>
					<div class="promo_desc_name"><a class="white" href="<?php echo $actions[1]['link']?>"><?php echo $actions[1]['name']?></a></div>
				<?php else :?>
					<div style="display:none !important;" class="promo_desc_name"><a class="white" href="<?php echo $actions[1]['link']?>"><?php echo $actions[1]['name']?></a></div>
				<?php endif;?>
				<?php if ($actions[1]['title'] != '') :?>
					<div class="promo_desc_text"><?php echo $actions[1]['title']?></div>
				<?php endif;?>
				
			</div>
		</div>
		<div class="sep_hor"></div>
		<div class="one_promo aloading sm_hor2">
			<img src="/img/promo_desc_bg.gif" width="10" height="10" style="opacity:0; position:absolute; top:-50px; z-index:-1;">
			<?php 
				$Arr1 = explode('|', $actions[2]['preview']);
				$Arr1 = array_diff($Arr1, array(''));
				$i = 1;
				foreach ($Arr1 as $k => $V){
					echo '<img id="1_'.$i.'" src="/uploads/'.$V.'"  width="460" height="224">';
					$i++;
				}
			?>
			<div class="promo_desc <?php if($actions[2]['plashka'] == 1) echo 'green'?>">
				<?php if ($actions[2]['name'] != '') :?>
					<div class="promo_desc_name"><a class="white" href="<?php echo $actions[2]['link']?>"><?php echo $actions[2]['name']?></a></div>
				<?php else :?>
					<div style="display:none !important;" class="promo_desc_name"><a class="white" href="<?php echo $actions[2]['link']?>"><?php echo $actions[2]['name']?></a></div>
				<?php endif;?>
				<?php if ($actions[2]['title'] != '') :?>
					<div class="promo_desc_text"><?php echo $actions[2]['title']?></div>
				<?php endif;?>
				
			</div>
		</div>
	</div>
	<div class="sep_vert"></div>
	
		<div class="one_promo aloading sm_ver1">
			<img src="/img/promo_desc_bg.gif" width="10" height="10" style="opacity:0; position:absolute; top:-50px; z-index:-1;">
			<?php 
				$Arr1 = explode('|', $actions[3]['preview']);
				$Arr1 = array_diff($Arr1, array(''));
				$i = 1;
				foreach ($Arr1 as $k => $V){
					echo '<img id="1_'.$i.'" src="/uploads/'.$V.'"   width="228" height="452">';
					$i++;
				}
			?>
			<div class="promo_desc <?php if($actions[3]['plashka'] == 1) echo 'green'?> ">
				<?php if ($actions[3]['name'] != '') :?>
					<div class="promo_desc_name"><a class="white" href="<?php echo $actions[3]['link']?>"><?php echo $actions[3]['name']?></a></div>
				<?php else :?>
					<div style="display:none !important;" class="promo_desc_name"><a class="white" href="<?php echo $actions[3]['link']?>"><?php echo $actions[3]['name']?></a></div>
				<?php endif;?>
				<?php if ($actions[3]['title'] != '') :?>
					<div class="promo_desc_text"><?php echo $actions[3]['title']?></div>
				<?php endif;?>
			</div>
		</div>
		<div class="sep_vert"></div>
		<div class="one_promo aloading sm_ver2">
			<img src="/img/promo_desc_bg.gif" width="10" height="10" style="opacity:0; position:absolute; top:-50px; z-index:-1;">
			<?php 
				$Arr1 = explode('|', $actions[4]['preview']);
				$Arr1 = array_diff($Arr1, array(''));
				$i = 1;
				foreach ($Arr1 as $k => $V){
					echo '<img id="1_'.$i.'" src="/uploads/'.$V.'"   width="228" height="452">';
					$i++;
				}
			?>
			<div class="promo_desc <?php if($actions[4]['plashka'] == 1) echo 'green'?>">
				<?php if ($actions[4]['name'] != '') :?>
					<div class="promo_desc_name"><a class="white" href="<?php echo $actions[4]['link']?>"><?php echo $actions[4]['name']?></a></div>
				<?php else :?>
					<div style="display:none !important;" class="promo_desc_name"><a class="white" href="<?php echo $actions[4]['link']?>"><?php echo $actions[4]['name']?></a></div>
				<?php endif;?>
				<?php if ($actions[4]['title'] != '') :?>
					<div class="promo_desc_text"><?php echo $actions[4]['title']?></div>
				<?php endif;?>
			</div>
		</div>
	
	<div class="sep_vert"></div>
	<div class="promo_column">
		<div class="one_promo aloading one_promo2">
			<img src="/img/promo_desc_bg.gif" width="10" height="10" style="opacity:0; position:absolute; top:-50px; z-index:-1;">
			<?php 
				$Arr1 = explode('|', $actions[5]['preview']);
				$Arr1 = array_diff($Arr1, array(''));
				$i = 1;
				foreach ($Arr1 as $k => $V){
					echo '<img id="1_'.$i.'" src="/uploads/'.$V.'" width="460" height="452">';
					$i++;
				}
			?>
			<div class="promo_desc <?php if($actions[5]['plashka'] == 1) echo 'green'?> ">
				<?php if ($actions[5]['name'] != '') :?>
					<div class="promo_desc_name"><a class="white" href="<?php echo $actions[5]['link']?>"><?php echo $actions[5]['name']?></a></div>
				<?php else :?>
					<div style="display:none !important;" class="promo_desc_name"><a class="white" href="<?php echo $actions[5]['link']?>"><?php echo $actions[5]['name']?></a></div>
				<?php endif;?>
				<?php if ($actions[5]['title'] != '') :?>
					<div class="promo_desc_text"><?php echo $actions[5]['title']?></div>
				<?php endif;?>
			</div>
		</div>
	</div>
	<div class="br"></div>
</div>

<script>
	$(function(){

		$('.one_promo').on('click', function(){
			location.href = $(this).find('.promo_desc_name a').attr('href')
		})
	})
</script>

<div class="wrap_sizes ">
<h1><?php echo $page['name']?></h1>
<p>Наш магазин находится по адресу: город Кинель​​​​​, <a class="fakeLink" href="#map">улица Орджоникидзе, дом 76</a>.</p>
<p>В наличии всегда широкий ассортимент свежих цветов. Приезжайте и выберите букет с витрины или закажите с доставкой.</p>
<br>
	 <!-- <div class="wrap_block resize_block fixed_height  <?if (isset($class)) echo $class;?>  a_load_block">
		
		<div class="block_label aloading"><h1>Магазин цветов в Кинеле</h1></div>
			
			
			<div id="products_line" class="products_line ">
				<?php $this->renderPartial('../catalog/items_line', array(
						'products' => $products,
						'sort' => false,
				));	?>
			</div> 
			
		</div>-->
	<?php foreach ($categories as $c) :?>
	<?php if (count($c['products']) > 0) :?>
	<div class="wrap_block resize_block fixed_height  <?if (isset($class)) echo $class;?>  a_load_block">
		<div class="block_label aloading"><a class="blue"  href="/catalog/<?php echo $c['uri']?>"><?php echo $c['name']?></a><sup>&nbsp;<?php echo Formats::getCountItems($c['count'])?></sup></div>
			<div id="products_line" class="products_line ">
				<?php $this->renderPartial('../catalog/items_line', array(
						'products' => $c['products'],
						'sort' => false,
						'catUri' => "/catalog/".$c[uri],
						'page' => 'index',
						'productsCount' => $c['count']
				));	?>
			</div>		
		</div>
		<?php endif;?>
	<?php endforeach;?>

	<div class="wrap_block home_bottom" style="border:none; margin-top:0; margin-bottom:0;">
		<div class="mini-contacts_left">
			<!--<div class="block_label ">О компании «Флау-вил»</div>-->
			<p><?php echo $page['text']?></p>
			<?php if (0) :?>
			<div class="block_label ">Схема проезда</div>
			<p style="margin:-5px 0 10px 0;"><?php echo $page['addres']?></p>
			
			<div class="mini-contacts_map" style="">
				<script type="text/javascript" charset="utf-8" src="//api-maps.yandex.ru/services/constructor/1.0/js/?sid=rsXqYWI5EOWtXJiWICC8iXN62vUefhs5&width=100%&height=247"></script>
			</div>
			<?php endif;?>
		</div>
		<!--<div class="mini-contacts_right">
			<div class="block_label ">Отзывы</div>
			<div class="mini-contacts_comments">
							
							<script type="text/javascript" src="//vk.com/js/api/openapi.js?105"></script>
							
							<script type="text/javascript">
							  VK.init({apiId: 4222157, onlyWidgets: true});
							</script>
							
							<div id="vk_comments"></div>
							<script type="text/javascript">
							VK.Widgets.Comments("vk_comments", {limit: 15, width: "380", height: "339", attach: "*"}, 123);
							</script>
							</div>
		</div>-->
		<div class="br"></div>
	</div>
</div>
