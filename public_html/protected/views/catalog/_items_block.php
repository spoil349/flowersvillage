<?php 
	$Cockiesort = Formats::getCoockieSort();
?>

<div style="<?php if (Yii::app()->user->getState('edit')) echo 'position:static !important';?>" class="wrap_block resize_block <?php if ($Cockiesort['smbig'] == 'big') echo 'big_block'?> <?php if (Yii::app()->user->getState('auth')) echo 'sortable' ?>   <?if (isset($class)) echo $class;?>">
		<h1 class="block_label aloading"><?php echo $label;?><?php if (!isset($class)) echo '<sup>&nbsp;'.count($products).'штук</sup>'?></h1>
		<?php if (isset($sort) && $sort) :
			
		//EA($Cockiesort);
		?>
		<?php  if (!empty($category['text'])) { ?>
			<div class="categoryText">
				<?php echo $category['text']?>
			</div>
		<?php } ?>
		<div style="position:relative;">
			<div class="sm_big_chahge aloading">
				<div class="one_sort_label">Вид каталога</div>
				<div class="s_big_img <?php if ($Cockiesort['smbig'] == 'big') echo 'select'?>"></div>
				<div class="s_sm_img <?php if ($Cockiesort['smbig'] == 'sm') echo 'select'?>"></div>
			</div>
			<div class="sort_product block_label aloading">
				<?php if ($category['feature_variants'] != ''):?>
				<div id="sort_type" class="one_sort">
					<?php 
						$Arrvar = explode('|', $category['feature_variants']);
					?>
					<div class="one_sort_label"><?php echo $category['feature_name']?></div>
					<div class="one_sort_label_variants">
						<a href="" class="blue select" >Все</a>
					<?php foreach ($Arrvar as $var):?>
						<a href="" class="blue " data-subtype="flowertype"><?php echo $var?></a>
					<?php endforeach;?>
					<?php if (!empty($categories) && count($categories) > 1) {
						foreach ($categories as $cat){ ?>
						<a href="" class="blue" data-subtype="cat" data-value="<?php echo $cat['id']?>"><?php echo $cat['name']?></a>
					<?php }
					}
					?>
					
					</div>
				</div> 
				<?php endif;?>
				<?php if ( isset($category['count']) && $category['count'] != 1 && !empty($priceRanges)) { ?>
				<div id="sort_price" class="one_sort">
					<div class="one_sort_label">Цена</div>
					<div class="one_sort_label_variants price">
						<a href="" data-price="" class="blue select" >Любая</a>
						<?php foreach ($priceRanges as $priceRange) { ?>
							<a href="" data-price="<?php echo $priceRange['prices']?>" class="blue " ><?php echo $priceRange['title']?></a>
						<?php } ?>
						<!--
						<a href="" data-price="1000" class="blue " >до&nbsp;1&nbsp;000</a>
						<a href="" data-price="1000-3000" class="blue">1&nbsp;000&ndash;3&nbsp;000</a>
						<a href="" data-price="3000-6000" class="blue " >3&nbsp;000&ndash;6&nbsp;000</a>
						-->
						<span><span class="b-rub">Р</span>
						</span>

					</div>
				</div>
				<?php } ?>
				<div  id="sort_sort" class="one_sort">
					<div class="one_sort_label">Сортировка</div>
					<div class="one_sort_label_variants">
						<a href="" data-sort="asc" class="blue" >По возрастанию</a>
						<a href="" data-sort="desc" class="blue" >По убыванию</a>
					</div>
				</div> 
				<div id="sort_price" class="one_sort">
					<div class="one_sort_label">Поиск по названию</div>
					<div class="one_sort_label_variants price">
					<form class="searchByName">
						<input name="searchByName" type="text" placeholder="Ввести название" maxlength="50" autocomplete="off">
					</form>
					</div>
				</div>
				<div class="br"></div>
			</div>
		</div>	
		
		<?php endif;?>
			<div id="products_line" class="products_line ">
				<?php $this->renderPartial('items_line', array(
						'products' => $products,
						'pages' => $pages,
						'sort' => $sort,
				));	?>
			</div>
		<?php if (1) :?>
		<div class="catalog_empty">Нет товаров</div>
		<?php endif;?>
				<div class="krutilka"></div>
</div>
