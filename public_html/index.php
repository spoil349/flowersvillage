<?php

ini_set('error_repoting',E_ALL);        //on
//ini_set('error_reporting',~E_ALL);      //off
ini_set('display_errors','on');


// change the following paths if necessary
#$yii=dirname(__FILE__).'/../yii_framework/yii.php';
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

function EA($obj){
	echo '<pre>';
	print_r($obj);
	echo '</pre>';
}

require_once($yii);
Yii::createWebApplication($config)->run();

