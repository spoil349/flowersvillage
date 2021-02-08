<?php

class SiteController extends Controller
{

	public $layout = 'main';
	
	public function pre($obj){
		echo '<pre>';
		print_r($obj);
		echo '</pre>';
	}

	public function actionIndex()
	{
		$db = Yii::app()->db;
			
			$db = Yii::app()->db;
			$sql = 'SELECT * FROM pages WHERE uri = "/"';
			$page= $db->createCommand($sql)->queryRow();
			
			$db = Yii::app()->db;
			$sql = 'SELECT * FROM banners WHERE id IN(1,2,3,4,5,6) Order by id ';
			$actions= $db->createCommand($sql)->queryAll();
			
			$this->pageTitle=$page['meta_title'].'';
			Yii::app()->clientScript->registerMetaTag($page['meta_description'], 'description');
			Yii::app()->clientScript->registerMetaTag($page['meta_keywords'], 'keywords');
		
 			$sql = 'SELECT p.*, c.uri as cat_uri FROM products p INNER JOIN  products_category pc ON pc.product_id = p.id INNER JOIN categories c ON c.id = pc.category_id WHERE   c.visibly = 1 AND c.hidden = 0  AND p.visibly = 1 AND p.hot = 1 GROUP by p.id ORDER by p.orders DESC LIMIT 0,10';
 			$products = $db->createCommand($sql)->queryAll();
			
 			$sql = 'SELECT c.* , COUNT(p.id) as count FROM categories c LEFT JOIN  products_category pc ON pc.category_id = c.id LEFT JOIN  products p ON pc.product_id = p.id WHERE c.visibly = 1 AND c.hidden = 0 AND p.visibly = 1 group by c.id order by c.orders ';
 			$categories = $db->createCommand($sql)->queryAll();
 			
 			foreach($categories as $K => $cat){

 				$sql = 'SELECT p.*, c.uri as cat_uri FROM products p INNER JOIN  products_category pc ON pc.product_id = p.id INNER JOIN categories c ON c.id = pc.category_id WHERE  c.id = '.$cat['id'].' AND c.visibly = 1  AND p.visibly = 1 GROUP by p.id ORDER by p.orders ASC LIMIT 0,14';
 				$categories[$K]['products'] = $db->createCommand($sql)->queryAll();
 			}
 			
 			
			$this->render('index', array(
					'products' => $products,
					'categories' => $categories,
					'actions' => $actions,
					'page' => $page,
					
			));
	}
	
	public function actionUpdate_instagram()
	{
		
		
		if (isset($_GET['hub_challenge'])) {
			echo $_GET['hub_challenge'];
		}
		$log = '';
		$ins = new GetInstagramItems;
		echo '1';
		
		$log = implode(',
', $ins->GetLast());
		
		$fp = fopen('check_sub.txt', 'a+');
		fwrite($fp, '

'.date("d-m-Y H:i:s").'		
'.$log.'

-----------------------------------------
');
		fclose($fp);
		
	}
	
	public function actionView()
	{
	
		$this->render('view', array(
	
		));
	}
	public function actionAbsolute()
	{
	
		$this->render('absolute', array(
	
		));
	}
	public function actionTranslate()
	{
	
		$this->render('translate', array(
	
		));
	}
	
	public function actionReviews()
	{

		$this->render('reviews', array(
		));
	}
	
	public function actionDelivery()
	{
		$db = Yii::app()->db;
		$sql = 'SELECT * FROM pages WHERE uri = "delivery"';
		$page= $db->createCommand($sql)->queryRow();
		
		$this->render('delivery', array(
				'page' => $page,
		));
	}
	
	public function actionAboutus()
	{
		$db = Yii::app()->db;
		$sql = 'SELECT * FROM about_slider';
		$slider= $db->createCommand($sql)->queryAll();
		
		$sql = 'SELECT * FROM pages WHERE uri = "aboutus"';
		$page= $db->createCommand($sql)->queryRow();
		
		
		$this->render('aboutus', array(
				'page' => $page,
				'slider' => $slider,
		));
	}
	
	public function actionContacts()
	{
 		$db = Yii::app()->db;
		$sql = 'SELECT * FROM pages WHERE uri = "contacts"';
		$page= $db->createCommand($sql)->queryRow();
		
		$this->pageTitle=$page['meta_title'].'';
		Yii::app()->clientScript->registerMetaTag($page['meta_description'], 'description');
		Yii::app()->clientScript->registerMetaTag($page['meta_keywords'], 'keywords');

		
		$this->render('contacts', array(
				'page' => $page,
		));
	}
	
	public function actionPayment()
	{
		$db = Yii::app()->db;
		$sql = 'SELECT * FROM pages WHERE uri = "payment"';
		$page= $db->createCommand($sql)->queryRow();
	
		$this->render('payment', array(
				'page' => $page,
		));
	}
	
	public function actionSendcall()
	{
		
		if(!Yii::app()->request->isPostRequest || $_POST['stat'] != 'send') {
			throw new CHttpException(404,'Страница не найдена');
		}
		$p = new CHtmlPurifier;
		$phone = $p->purify($_POST['phone']);
		$name = $p->purify($_POST['name']);
			
		if ($name != '' && $phone != ''){
			$mail = new SendToMail();
			$mail->SendCall(array('phone' => $phone, 'name' => $name));
		}
	}
	
	public function actionPage($alias)
	{
		$db = Yii::app()->db;
		$sql = "SELECT * FROM pages WHERE uri = '$alias'";
		$page= $db->createCommand($sql)->queryRow();
		
		if (empty($page)) {
			throw new CHttpException(404,'Ой, такой страницы нет');
		}
		
		$this->render('page', array(
			'page' => $page,
		));
	}
	
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else{
				$db = Yii::app()->db;
				$sql = 'SELECT p.*, c.uri as cat_uri FROM products p INNER JOIN  products_category pc ON pc.product_id = p.id INNER JOIN categories c ON c.id = pc.category_id WHERE   c.visibly = 1  AND p.visibly = 1 AND p.hot = 1 GROUP by p.id ORDER by p.orders DESC LIMIT 0,10';
				$error['products'] = $db->createCommand($sql)->queryAll();
				
				$this->render('error', $error);
			}
		}
	}
	
	public function actionLogin()
	{
		$this->pageTitle='Авторизация — '.Yii::app()->name.'';
		
		if(isset($_POST['pass']))
		{
			$model=new LoginForm;
			$model->password=$_POST['pass'];
// 			echo $_POST['pass'].'<br>';
// 			$so = rand(100000000, 1000000000);
// 			echo $so.'<br>';
// 			echo md5($_POST['pass'].$so).'<br>';
			//validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
				if (isset($_POST['stat']))
					echo $_SERVER['HTTP_REFERER'];
				else 
					$this->redirect('/');
			} else { 
				if (isset($_POST['stat']))
					 echo '';
				else
					$this->render('login', array('error' => 1));		
			}
	
		} else {
			$this->render('login', array('error' => 0));
		}

	}

	public function actionLogout()
	{	
		Yii::app()->user->logout();
			Yii::app()->user->setState( 'auth', false);
			if(isset($_POST['stat']) && $_POST['stat'] == 'logout') {
				echo $_SERVER['HTTP_REFERER'];
			} else 
				$this->redirect($_SERVER['HTTP_REFERER']);
			
		
	}
	
	public function actionEdit()
	{

		if (!Yii::app()->user->getState('auth') || !isset($_GET['stat']))
				throw new CHttpException(404,'Страница не найдена');
		
		if ($_GET['stat'] == 'edit'){
			if (Yii::app()->user->getState('edit')){
				Yii::app()->user->setState( 'edit', false);
			}else{
				Yii::app()->user->setState( 'edit', true);
			}
			$this->redirect($_SERVER['HTTP_REFERER']);
		} elseif ($_GET['stat'] == 'sort' && isset($_GET['sort_line'])) {
			$db = Yii::app()->db;
			$ArrCat = explode('|', $_GET['sort_line']);
			foreach ($ArrCat as $V){
				if ($V!= ''){
					$Arrsort = explode('-', $V);
					$sql = 'UPDATE products SET orders='.$Arrsort[1].' WHERE id='.$Arrsort[0].'';
					$db->createCommand($sql)->execute();
				}
			}
		}
	}
		
// 	public function actionSitemap()
// 	{
// 		$this->layout ='application.view.layouts.clearn';
// 		$this->layoutPath ="protected/view/layouts";
	
// 		$ARR_products = Yii::app()->db->createCommand()
// 		->select('id, cat_uri')
// 		->from('products')
// 		->where('no_active="0"')
// 		->queryALL();
	
// 		$ARR_categories = Yii::app()->db->createCommand()
// 		->select('id, uri')
// 		->from('catalog')
// 		->where('no_active="0"')
// 		->queryALL();
	
// 		$ARR_pages = Yii::app()->db->createCommand()
// 		->select('id, uri')
// 		->from('pages')
// 		->where('id!=""')
// 		->queryALL();
	
// 		$this->render('sitemap', array(
// 				'ARR_products' => $ARR_products,
// 				'ARR_categories' => $ARR_categories,
// 				'ARR_pages' => $ARR_pages,
// 		)
// 		);
// 	}
}