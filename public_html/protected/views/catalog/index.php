<style>
.any_bield { position: absolute; margin:0 !important;}
</style>
<div class="wrap_sizes " style="overflow:hidden;">
	<?php $this->renderPartial('../catalog/_items_block', array(
			'products' => $products,
			'category' => $category,
			'categories' => $categories,
			'label' => $label,
			'total' => $total,
			'class' => 'border_none',
			'sort' => true,
			'pages' => $pages,
			'priceRanges' => $priceRanges,
	));	?>
	<?php  if (isset($C['description']) && $C['description'] != "") :?>
		<div class="wrap_block  description_block " style="min-height: 0px;">
			<div class="block_label"><?php echo $C['label_description']?></div>
			<div style="margin-top:20px;max-width:720px;"><?php echo $C['description']?></div>
		</div>
	<?php endif;?>
	<?php
		//pinterest widget script в разделе свадебных букетов
		if ($category['id'] == 74) {
			echo '<script async defer src="//assets.pinterest.com/js/pinit.js"></script>';
		}
	?>
</div>

<pre style="display: none;">
<?php //print_r($products)?>
</pre>