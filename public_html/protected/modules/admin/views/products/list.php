<?php 
// 	$this->widget('application.modules.admin.extensions.Admin.AddNew',array(
// 		'Arrfield'=> array (
// 			array( 'name' => 'name', 'label' => 'Название', 'type'=> 'text',),
// 			array( 'name' => 'cat_id', 'label' => 'Катеория', 'type'=>'multiselect', 'arrval'=> $ARRcat),
// 		),
// 		'label'=> 'Новый товар',
// 	    'table'=> 'products',
// 	));
	?>

<div class="content_left">
<?php 
 
//EA($ARRitems);
?>
<?php
$this->widget('application.modules.admin.extensions.Admin.Listing',array(
		'ARRitems'=> $ARRitems,
		'ARRfields' => array(
				array('name'=> 'img', 'label'=> 'Изображение' , 'link' => true , 'style' => ''),
				array('name'=> 'name', 'label'=> 'Название' , 'link' => true , 'style' => 'text-align:left;'),
				array('name' => 'price', 'label' => 'Цена (р)'),
				array('name'=> 'categories_list', 'label'=> 'Название' , 'style' => 'text-align:left;'),
				
		),
		
		'id_table'=> 'products',
		'class_table'=> 'small_table',
		'table_label'=> 'Товары',
		'field_sort'=> true,
		'tr_sort'=> false,
		'empty_message'=> 'Товаров нет',
		'count_labels'=> array('товар','товара','товаров'),
		'new_label'=> 'Добавить товар...',
));

?>
</div>
<div class="content_right">
	<?php 
	$this->widget('application.modules.admin.extensions.Admin.CatalogMenu',array(
			'Catalog'=> $Catalog,
			'select_cat'=> $id,
	));
	?>
	<div class="content_right_menu2">
	</div>
</div>
<div class="br"></div>
