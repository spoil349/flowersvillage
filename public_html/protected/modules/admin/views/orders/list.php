<div class="content_left">
<?php 
$this->widget('application.modules.admin.extensions.Admin.Listing',array(
	'ARRitems'=> $ARRitems,
	'ARRfields' => array(
		array('name'=> 'id', 'label'=> '№' , 'link' => true , /*'style' => 'width:60px;text-align:center;'*/),
		array('name'=> 'date', 'label'=> 'Дата'),
		array('name'=> 'time', 'label'=> 'Время'),
		array('name'=> 'to_name', 'label'=> 'Имя' ),
		array('name'=> 'to_phone', 'label'=> 'Телефон', 'style' => 'width:120px;' ),
		array('name' => 'discount_price', 'label' => 'Сумма&nbsp;(р)'),
		array('name' => 'comment', 'label' => 'Примечание'),
	),
	
	'id_table'=> 'orders',
	'class_table'=> 'small_table',
	'table_label'=> 'Заказы',
	'field_sort'=> true,
	'tr_sort'=> false,
	'empty_message'=> 'Заказов нет',
	'panel'=> false,
));

?>
</div>
<div class="content_right">
	<?php 
	$this->widget('application.modules.admin.extensions.Admin.RightMenu',array(
			'row'=> $ARRstatus,
			'select_uri'=> Yii::app()->request->url,
			'map_url'=> '/admin/orders/list/{uri}',
			'All_label'=> 'Все заказы',
			'Field_name'=> 'many_name'
	));
	?>
	<div class="content_right_menu2">
	</div>
</div>
<div class="br"></div>
