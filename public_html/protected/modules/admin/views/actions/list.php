
<div class="content_left">
<?php
$this->widget('application.modules.admin.extensions.Admin.Listing',array(
		'ARRitems'=> $ARRitems,
		'ARRfields' => array(
				array('name'=> 'name', 'label'=> 'Название' , 'link' => true,  'style' => 'text-align:left;'),
				array('name'=> 'categories_list', 'label'=> 'Категории' , 'style' => 'text-align:left;'),
				
		),
		
		'id_table'=> 'actions',
		'class_table'=> 'small_table',
		'table_label'=> 'Акции',
		'field_sort'=> true,
		'tr_sort'=> false,
		'empty_message'=> 'Акций нет',
		'count_labels'=> array('акция','акции','акций'),
));

?>
</div>
<div class="br"></div>
