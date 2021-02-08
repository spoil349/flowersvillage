
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html style="height:100%" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	
	<title>Администрирование <?php echo $this->pageTitle ?></title>	
	<link rel="apple-touch-icon-precomposed" href="apple-touch-favicon.png"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/chosen.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/admin.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/apprise.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/ui-calendar.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/jquery.rating.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin/redactor.css" />
	
	<?php 
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/admin/jquery.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/admin/chousen.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/admin/jquery.tablesorter.min.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/admin/jquery.sticky.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/admin/jquery-ui-1.9.2.custom.min.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/admin/spin.min.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/admin/apprise-1.5.min.js', CClientScript::POS_HEAD);
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/admin/ui-calendar.min.js', CClientScript::POS_HEAD);	
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/admin/jquery.rating.js', CClientScript::POS_HEAD);
	if (Yii::app()->controller->getId() == 'orders' ) Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/admin/redactor.js', CClientScript::POS_HEAD);
	
	
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/admin/admin_'.Yii::app()->controller->getId().'.js', CClientScript::POS_HEAD);	
	?>
</head>

<body style="min-height:88%; height:auto;   width:100%; position:relative; padding-bottom:1%; ">
<?php 
$this->widget('application.modules.admin.extensions.Admin.AdminMenu',array(
		'row'=> array (
				array( 'uri' => '/admin/categories', 'label' => 'Категории'),
				array( 'uri' => '/admin/products', 'label' => 'Товары'),	
				array( 'uri' => '/admin/features', 'label' => 'Свойства'),
				array( 'uri' => '/admin/actions', 'label' => 'Акции'),
				array( 'uri' => '/admin/banners', 'label' => 'Баннеры',),
				array( 'uri' => '/admin/pages', 'label' => 'Страницы'),
				array( 'uri' => '/admin/orders', 'label' => 'Заказы'),
				
				
				
				


				
				
				

		),
		'select_uri'=> Yii::app()->request->url,
));
?>
	
	<div class="main" style="min-height:90%; position:relative;">
		<span class="main_ajax_save">Сохранено</span>
		<?php echo $content; ?>
	<div class="br"></div>
	<div class="br"></div>
	</div>
	<div class="footer">
		<div class="artcream">Сайт разработан в <a href="http://artcream.ru" class="artcream_logo">
		<span class="artcream_text">Арткриме</span></a>
	</div>
	</div>
	
	
	<script>
		jQuery(document).ajaxStart(function() {
			$('.main_ajax_save').addClass('active')
		}).ajaxStop(function() {
			setTimeout(function(){
				$('.main_ajax_save').removeClass('active')
			},1500)
			
		});
	</script>
</body>
</html>
