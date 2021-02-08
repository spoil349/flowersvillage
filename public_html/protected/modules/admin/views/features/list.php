<div class="content_left">
<?php
$this->widget('application.modules.admin.extensions.Admin.Listing',array(
		'ARRitems'=> $ARRitems,
		'ARRfields' => array(
				array('name'=> 'name', 'label'=> 'Название' , 'link' => true,  'style' => 'text-align:left;'),
				array('name'=> 'type_name', 'label'=> 'Тип' ),
				array('name'=> 'variants', 'label'=> 'Значения' , 'replace'=>array('|', ', ')),
		),
		
		'id_table'=> 'features',
		'class_table'=> 'small_table',
		'table_label'=> 'Свойста',
		'field_sort'=> true,
		'tr_sort'=> false,
		'empty_message'=> 'Свойств нет',
		'count_labels'=> array('свойство','свойства','свойств'),
		'panel' => false,
));

?>
</div>
<div class="content_right">
	
</div>
<div class="br"></div>
