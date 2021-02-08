<?php 
$this->widget('application.modules.admin.extensions.Admin.AddNew',array(
		'Arrfield'=> array (
				array( 'name' => 'name', 'label' => 'Название', 'type'=> 'text',),
				array( 'name' => 'uri', 'label' => 'Адрес (ENG)', 'type'=> 'text',),
		),
		'label'=> 'Новая Секция',
		'table'=> 'sections',
));

	
$this->widget('application.modules.admin.extensions.Admin.OneSection',array(
		'ARRsection'=> $ARRsection,
));




