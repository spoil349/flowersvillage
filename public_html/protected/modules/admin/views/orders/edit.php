<div class="content_left">
<?php

$this->widget('application.modules.admin.extensions.Admin.OneOrder',array(
		'ARRorder'=> $ARRorder,
		'ARRstatus'=> $ARRstatus,
		'ARRdelivery'=> $ARRdelivery,
		'ARRpayment' => $ARRpayment,
		'ARRpaid' => $ARRpaid,
));
?>
</div>
<div class="content_right">
<?php 
	$this->widget('application.modules.admin.extensions.Admin.RightMenu',array(
			'row'=> $ARRstatus,
			'select_uri'=> Yii::app()->request->url,
			'map_url'=> '/admin/orders/list/{uri}',
			'All_label'=> 'Все заказы',
			'Field_name'=> 'many_name'
	));
	?>

</div>
<div class="br"></div>
<div id="addimg_other_popup" class="addimg_other_popup orders_popup">
	<div class="popup_label">Выберите подходящую вещь</div>
	<div class="popup_del"><img src="/images/big_del.jpg"></div>
	<div class="br"></div>
	<div class="popup_content"></div>
	<div class="popup_wait" id="popup_wait"></div>
</div>