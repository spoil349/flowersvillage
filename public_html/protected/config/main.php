<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Флау-Вил',
		
	'language'=>'ru',
		
	// preloading 'log' component
	'preload'=>array('log'),
	'aliases'=>array(
		'bootstrap'=>'ext.bootstrap',
		'widget'=>'application.components.widgets',
	),
		

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.extensions.yiinstagram.*',
		'application.extensions.transport.*',
		'application.components.*',
 		'application.modules.admin.models.*',
 		'application.modules.admin.components.*',
		
		'bootstrap.helpers.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'11',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'admin'=>array(
			
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			//'allowAutoLogin'=>false,
			//'class' => 'Users',
		),
		'mailer' => array(
				'class' => 'application.extensions.mailer.EMailer',
				'pathViews' => 'application.views.email',
				'pathLayouts' => 'application.views.email.layouts'
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'login' => 'site/login',
				'logout' => 'site/logout',
                                'edit' => 'site/edit',
                                'update_instagram' => 'site/update_instagram',
				'delivery' => 'site/delivery',
				'reviews' => 'site/reviews',
				'aboutus' => 'site/aboutus',
				'contacts' => 'site/contacts',
				'payment' => 'site/payment',
				'sendcall' => 'site/sendcall',
				'confirmation' => 'basket/confirmation',
				'errorpayment' => 'basket/errorpayment',
				'pay' => 'basket/pay',
				
				'<module:admin>'=>'admin/products/list',
				'<module:admin>/<controller:\w+>'=>'admin/<controller>/index',
				'<module:admin>/<controller:\w+>/<action:\w+>'=>'admin/<controller>/<action>',
				'<module:admin>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'admin/<controller>/<action>/<id:\d+>',
				'<module:admin>/<controller:\w+>/<action:\w+>/<cat_uri:\w+>'=>'admin/<controller>/<action>/<cat_uri:\w+>',
				
                                '<controller:catalog>'=>'catalog/index',
                                '<controller:catalog>/<action:sort>'=>'catalog/sort',
				'<controller:catalog>/<action:add>/<id:\d+>'=>'catalog/add',
				'<controller:catalog>/<action:delete>/<id:\d+>'=>'catalog/delete',
				'<controller:catalog>/<action:delall>'=>'catalog/delall',
				'<controller:catalog>/<uri:[a-z0-9-_]+>'=>'catalog/index',
				'<controller:catalog>/<uri:[a-z0-9-_]+>/<id:\d+>'=>'catalog/index',

                                '<controller:actions>/<id:\d+>'=>'actions/index',
				
				'<controller:order>'=>'order/index',
				'<alias>' => 'site/page',
 				'<controller:\w+>'=>'<controller>/index',
 				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
 				
				
 				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<section:\w+>'=>'<controller>/index',
				'<controller:\w+>/<section:\w+>/<cat:\w+>'=>'<controller>/index',
				'<controller:\w+>/<section:\w+>/<cat:\w+>/<id:\d+>'=>'<controller>/view',
				
				),
			'showScriptName'=>false,
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=tulip63ru_shop',
			'emulatePrepare' => true,
			'username' => 'tulip63ru_shop',
			'password' => '2L0bXggmG2015',
			'charset' => 'utf8',
			'tablePrefix' => ''
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'instagram' => array(
				'class' => 'ext.yiinstagram.InstagramEngine',
				'config' => array (
						'client_id' 		=> '3c2a13328a3b49508fb4390dcd97c8bc',
						'client_secret'   	=> 'f7f18aa8a9dd4b608522bb4a7110f1b7',
						'grant_type' 		=> 'authorization_code',
						'redirect_uri' 		=> 'http://flau.psvp.ru/access_instagram',
				)
				//login art4test
				//pass testtest
                                // verify_token : 557ec57d25a4bba105ff87a0a64c134
		),
		
		'bootstrap'=>array(
				'class'=>'bootstrap.components.Bootstrap',
		),
		'cache'=>array(
		   'class'=>'system.caching.CFileCache',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		'production' => false,
	
		// this is used in contact page
		'adminEmail'=>'shny0990@gmail.com',
		'toEmail'=>  array('shny0990@gmail.com', 'sharapovyura@yandex.ru', 'cvetykinel@yandex.ru'),
		//'toEmail'=>  array('solovyev@liderpoiska.ru'),
                //'toPhone'=> array(''),
                 'toPhone'=> array(),
				
////////// SMTP MAIL CONFIG		
		
		'smtp_host' => 'smtp.gmail.com',
		'smtp_port' => 465,
		'smtp_username' => '',
		'smtp_password' => '',
		
		'instagram_token'=>'690586638.1fb234f.fd3530215e144435bfa6b6bcac53f829',
		'instagram_id'=>'690586638',
		'instagram_select_tag' => 'flauvil',
			
	),
);