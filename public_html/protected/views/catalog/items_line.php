
<div class="ias_parent catalog-page <?php echo $page == 'index' ? 'index' : ''?>">
<?php 
$i = 0;
foreach( $products as $product) :
		$i++;
				$Arrimg = explode('|', $product['img']);
				$Arrimg = array_diff($Arrimg, array(''));

				?>
				<div class="item ani_box aloading ias_child " <?php if (Yii::app()->user->getState('auth')) echo 'id="item_'.$product['id'].'"' ?>>
					<?php if ($product['hot'] == 1) echo '<span class="hot_item"></span>'?>
					<a href="/catalog/<?php echo $product['cat_uri']?>/<?php echo $product['id']?>"><img src="/uploads/300x300/<?php echo current($Arrimg);?>" class=" "></a>
					
						<input type="hidden" class="sortprice" value="<?php echo $product['price']?>">
					<?php if (isset($product['feature_value'])) :?>
						<input type="hidden" class="sorttype" value="<?php echo $product['feature_value']?>">
						<input type="hidden" class="sortorder" value="<?php echo $product['orders']?>">
						<input type="hidden" data-sort="category" value="<?php echo $product['cat_id']?>">
					<?php endif;?>
					<div class="item_desc">
						<a class="blue" href="/catalog/<?php echo $product['cat_uri']?>/<?php echo $product['id']?>"><?php echo $product['name']?></a><br>
						<span class="item_price"><?php echo number_format( $product['price'], 0, ',', ' ' );?> <span class="b-rub">Р</span></span>
					</div>
				</div>
				<?php if ($page == 'index' && ($i > 5 || $i>= $productsCount)) { ?>
					<div class="item products_allButton">
						<span class="products_allButton_text">
							Показать все
							<a href="<?php echo $catUri; ?>" class="blue"><?php echo $productsCount?>&nbsp;наименовани<?php echo Formats::end_eyai($productsCount)?></a>
						</span>
						<a href="<?php echo $catUri; ?>" class="products_allButton_arrow"></a>
					</div>
				<?php break; } ?>
		<?php endforeach;?>
<div class="br"></div>

</div>
<div class="br"></div>
<?php if (isset($pages)):?>
<div class="ias_pager">
	<?php
 			$this->widget('CLinkPager', array(
 				'pages'=>$pages,
 			));
		?>
</div>
<?php endif;?>