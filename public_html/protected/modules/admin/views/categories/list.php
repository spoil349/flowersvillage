	<link rel="stylesheet" type="text/css" href="/css/admin/redactor.css" />
	<script type="text/javascript" src="/js/admin/redactor/redactor.js"></script>
<div class="content_left">

<?
$this->widget('application.modules.admin.extensions.Admin.Listing',array(
		'ARRitems'=> $ARRitems,
		'ARRfields' => array(
				array('name'=> 'name', 'label'=> 'Название' , 'link' => true , 'style' => 'text-align:left;'),
				array('name'=> 'uri', 'label'=> 'Адрес(ENG)', 'style'=> '' ),
		),
		
		'id_table'=> 'categories',
		'class_table'=> '',
		'table_label'=> 'Категории',
		'field_sort'=> true,
		'tr_sort'=> false,
		'empty_message'=> 'Категорий нет',
		'count_labels'=> array('категория','категории','категорий'),
		'new_label'=> '',
));

?>
</div>
<div class="content_right">
</div>
