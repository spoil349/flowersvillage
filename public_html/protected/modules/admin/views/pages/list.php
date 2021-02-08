<div class="content_left">
<?php 
$this->widget('application.modules.admin.extensions.Admin.Listing',array(
		'ARRitems'=> $ARRitems,
		'ARRfields' => array(
				array('name'=> 'name', 'label'=> 'Название' , 'link' => true , 'style' => 'text-align:left;'),
				array('name'=> 'uri', 'label'=> 'Адрес(ENG)', 'style'=> '' ),
				array('name'=> 'meta_title', 'label'=> 'Ключевые_слова' , 'count'=>true ,'style'=> 'width:300px;'),
		),
		
		'id_table'=> 'pages',
		'class_table'=> '',
		'table_label'=> 'Страницы',
		'field_sort'=> true,
		'tr_sort'=> false,
		'empty_message'=> 'Страниц нет',
		'panel' => false,
));
?>
<br>
<a href="/admin/pages/new/" class="green_btn btn_def2">Добавить страницу</a>
</div>
<div class="content_right">
	
</div>
<div class="br"></div>

