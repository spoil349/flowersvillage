
<div class="content_left">
<?php
$this->widget('application.modules.admin.extensions.Admin.Listing',array(
		'ARRitems'=> $ARRitems,
		'ARRfields' => array(
				array('name'=> 'name', 'label'=> 'Название' , 'link' => true,  'style' => 'text-align:left;'),
				array('name'=> 'size', 'label'=> 'Размер' ),
				
		),
		
		'id_table'=> 'banners',
		'class_table'=> 'small_table',
		'table_label'=> 'Баннера',
		'field_sort'=> true,
		'tr_sort'=> false,
		'empty_message'=> 'Акций нет',
		'count_labels'=> array('баннер','баннера','баннеров'),

		'panel' => false,
));

?>
</div>
<div class="br"></div>
