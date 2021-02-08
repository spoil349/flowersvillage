<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="language" content="en" />
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
	<title><?php echo $this->pageTitle ?></title>
	
	<link href="/css/template.css?v=4" type="text/css" rel="stylesheet" />
	<link href='http://fonts.googleapis.com/css?family=PT+Serif:400,700&subset=latin,cyrillic-ext,cyrillic' rel='stylesheet' type='text/css'>
		<!--[if lt IE 8 ]>
			<link href="/css/ie7.css?v=0" type="text/css" rel="stylesheet" />
		<![endif]-->
	<script type="text/javascript" src="/js/jquery_modernizr.js"></script>
	<?php if (Yii::app()->user->getState('edit')) :?>
		
		<script type="text/javascript" src="/js/jquery-ui-1.9.2.custom.min.js"></script>	
	
	<?php endif;?>
	
	<!-- Media queries -->
  <link rel="stylesheet" href="/css/media-queries.css?v=4">
  <script src="/js/toggle-menu.js"></script>
</head>
<body <?php if (Yii::app()->user->getState('edit')) echo 'class="body_edit"'?>>
  <!-- Toggle menu -->
  <div class="toggle-wrap">
    <button type="button" class="toggle-menu" id="toggleMenu">
      <span></span>
      <span></span>
      <span></span>
    </button>
  </div>
	<?php if (0):?>
		<div class="admin_line">
			<div class="admin_menu">
			<span>пользователь: <b><?php echo Yii::app()->user->getState('username')?></b></span>&nbsp;|&nbsp; 
			<a href="/admin/products/" class="gray">Администрирование</a>
			<a  title="Выйти" href="/logout" class="logout" id="logout2"></a>
			
			</div>
		</div>
	<?php endif;?>
				<?php 
				 	$this->widget('widget.Basket',array(
							'aloading' => (Yii::app()->controller->id == '_site' && Yii::app()->controller->action->id == 'index') ? true : false,
					));
				?>
				
					
				
	<div style="width:100%; height:50px;">		
	<div class="wrap_header <?php if (Yii::app()->controller->id == '_site' && Yii::app()->controller->action->id == 'index') echo 'aloading'?>">
		<div class="wrap_sizes">
			<div class="logo">
				<?php if (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'index'  ):?>
					<img src="/img/logo.jpg" width="265" height="33">
				<?php else : ?>
					<a href="/"><img src="/img/logo.jpg" width="265" height="33"></a>
				<?php endif;?>
			</div>
			<?php 
			 	$this->widget('widget.CatalogMenu',array(
					'cat' => Yii::app()->request->url,		
				));
			?>
			
			<div class="header_phone">
				
				<?php if (!Yii::app()->user->getState('auth')) :?>
					<a href="tel:+79967414590"><span></span> +7 (996) 741-45-90</a>
					<a href="https://www.instagram.com/cvety_kinel/" class="iconInst" target="_blank"></a>
				<?php else :?>
					<a style="font-size:14px; margin-top:2px; line-height:1em; float:left; display:block;" href="/admin/products/" class="gray">Редактирование</a>
					<a href="/edit?stat=edit" class="non front_edit <?php if (Yii::app()->user->getState('edit')) echo 'enable'?>"></a>
					<div class="br"></div>
				<?php endif;?>
			</div>
			<div class="br"></div>
		</div>
	</div>
	</div>
	<?php echo $content;?>
<div class="wrap_sizes" id="map">
	<div class="contact_label2" style="margin-bottom:20px;">Схема проезда</div>	
	<div style="width:100%; height:500px;	border-radius:15px; border:1px solid #ddd;">
		<?php /*<script type="text/javascript" charset="utf-8" src="//api-maps.yandex.ru/services/constructor/1.0/js/?sid=CIkDQ7T3ELYNfF-UEVYhE4SfklDVANj8&height=500"></script>*/?>
		<iframe src="https://yandex.ru/map-widget/v1/?z=12&ol=biz&oid=129741371697" width="100%" height="500" frameborder="0"></iframe>
	</div>
</div>
<div style="width:100%; height:130px;"></div>
	<div class="footer">
		<div class="wrap_sizes">
			<div class="footer_left">© 2004–<?php echo date('Y')?>  <a href="/">Цветы в Кинеле</a></div>
			<!--<div style="width:25%;text-align:left; float:left"><a class="gray" href="/actions">Акции</a><a class="gray" style="margin-left:30px" href="/contacts">Контакты</a></div> 
			<div class="artcream">Сайт разработан в <a href="http://artcream.ru" class="artcream_logo">
				<span class="artcream_text">Арткриме</span></a>
			</div>-->
			<div class="br"></div>
		</div>
	</div>
	<div class="footer_lock">
		<?php if (!Yii::app()->user->getState('auth')) {?>
			<a title="Войти"  href="#" id="login" class="login"></a>
		<?php } elseif (Yii::app()->user->getState('auth')) {?>
			<a  title="Выйти" href="#" class="logout" id="logout"></a>
			
		<?php }?>
		
	</div>
	<div class="footer_login "><input class="login_input" type="password" placeholder="Введите пароль" id="login_input" value=""></div>
	
	<script type="text/javascript" src="/js/template.js?v=120121"></script>
	
	<?php 
		$db = Yii::app()->db;
		$sql = 'SELECT * FROM pages WHERE uri = "/"';
		$C = $db->createCommand($sql)->queryRow();
		
		echo $C['counter'];
	?>
</body>
</html>
