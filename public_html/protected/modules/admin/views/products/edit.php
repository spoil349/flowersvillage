<link rel="stylesheet" type="text/css" href="/css/jcrop/jquery.Jcrop.css" />
<script type="text/javascript" src="/js/jcrop/jquery.Jcrop.js"></script>

<div class="content_left">
<?php
$this->widget('application.modules.admin.extensions.Admin.OneProduct',array(
		'ARRitem'=> $ARRitem,
		'ARRcat'=> $ARRcat,
		'ARRaction'=> $ARRaction,
));
?>
</div>
<div class="content_right"> 
<?php 
	$this->widget('application.modules.admin.extensions.Admin.CatalogMenu',array(
			'Catalog'=> $Catalog,
			'select_cat'=> $id,
	));
?>
</div>
<div class="br"></div>
<div id="addimg_other_popup" class="addimg_other_popup orders_popup">
	<div class="popup_label">Выберите подходящий товарs</div>
	<div class="popup_del"><img src="/img/big_del.jpg"></div>
	<div class="br"></div>
	<div class="popup_content"></div>
	<div class="popup_wait" id="popup_wait"></div>
</div>