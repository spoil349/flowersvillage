<style>
.any_bield { position: absolute; margin:0 !important;}
</style>
<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle='Ошибка 404';
$this->breadcrumbs=array(
	'Error',
);
?>
	<?php $message = CHtml::encode($message);?>
	<div class="wrap_sizes">
		<div class="wrap_block p404">
			<div class="page404">
				<div class="page404_desc">
						<div class="page404_desc_name"><span><?php if ( $message == 'Ой, такого товара нет') echo 'Ой, такого товара нет'; else echo 'Ой, такой страницы нет' ?></span></div>
						<?php if ( $message == 'Ой, такого товара нет') :?>
							<div class="page404_desc_text">Вы допустили ошибку в адресе, либо такого товара больше нет.
								<br><br>Наверняка вы найдете его в <a class="blue" href="/catalog">каталоге</a>.</div>
						<?php else :?>
							<div class="page404_desc_text">Вы допустили ошибку в адресе, либо такой страницы больше нет. 
								<br><br>Лучше посмотрите все товары в <a class="blue" href="/catalog">каталоге.</a></div>
						<?php endif;?>
				</div>
				<div class="error"></div>
			
			</div>
		</div>
	</div>
	<div style="width:100%; height:1px; background-color:#ddd;"></div>
	<div class="wrap_sizes">
		<div class="wrap_block resize_block  fixed_height border_none a_load_block big_block" style="height:400px;">
			<div class="block_label aloading">Популярные букеты</div>
				<div id="products_line" class="products_line ">
					<?php $this->renderPartial('../catalog/items_line', array(
							'products' => $products,
							'sort' => false,
					));	?>
				</div>
			
		</div>
	</div>