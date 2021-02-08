	<script type="text/javascript" src="/js/redactor.js"></script>
	<link rel="stylesheet" type="text/css" href="/css/redactor.css" />

<?php 
	$this->widget('application.modules.admin.extensions.Admin.AddNew',array(
		'Arrfield'=> array (
			array( 'name' => 'name', 'label' => 'Имя', 'type'=> 'text',),
			
		),
		'label'=> 'Новый отзыв',
	    'table'=> 'reviews',
	));
	?>

<div class="content_left">
<?php 
$this->widget('application.modules.admin.extensions.Admin.Listing',array(
		'ARRitems'=> $ARRitems,
		'ARRfields' => array(
				array('name'=> 'name', 'label'=> 'Имя' , 'link' => true , 'style' => 'text-align:left; '),
		),
		
		'id_table'=> 'reviews',
		'class_table'=> 'small_table',
		'table_label'=> 'Отзывы',
		'field_sort'=> false,
		'tr_sort'=> false,
		'empty_message'=> 'Отзывов нет',
));

?>
</div>

