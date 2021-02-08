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

$this->widget('application.modules.admin.extensions.Admin.OneReview',array(
		'ARRitem'=> $ARRitem,
));
?>
</div>
