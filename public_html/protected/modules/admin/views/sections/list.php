<?php 
$this->widget('application.modules.admin.extensions.Admin.AddNew',array(
		'Arrfield'=> array (
				array( 'name' => 'name', 'label' => 'Название', 'type'=> 'text',),
				array( 'name' => 'uri', 'label' => 'Адрес (ENG)', 'type'=> 'text',),
		),
		'label'=> 'Новая Секция',
		'table'=> 'sections',
));

$this->widget('application.modules.admin.extensions.Admin.Listing',array(
		'ARRitems'=> $ARRitems,
		'ARRfields' => array(
				array('name'=> 'name', 'label'=> 'Название' , 'link' => true , 'style' => 'text-align:left;'),
				array('name'=> 'uri', 'label'=> 'Адрес(ENG)', 'style'=> '' ),
		),
		
		'id_table'=> 'sections',
		'class_table'=> '',
		'table_label'=> 'Секции',
		'field_sort'=> true,
		'tr_sort'=> false,
		'empty_message'=> 'Секций нет',
));

?>

