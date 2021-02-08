<?php

class ActionsController extends Controller
{

	public $layout = 'main';
	
	public function actionIndex($id = '')
	{
		$db = Yii::app()->db;
		
		if($id == ''){
			$this->pageTitle='Акции';
			
			$sql = 'SELECT * FROM actions WHERE visibly = 1 ORDER by id DESC';
			$actions = $db->createCommand($sql)->queryAll();
			$this->render('index', array(
					'actions' => $actions,
			));
			
		} else {
			if(Yii::app()->request->isPostRequest || isset($_POST['Call'])){
			
				$mail = new SendToMail();
				$mail->SendCall($_POST['Call']);
			
				echo CJSON::encode(array(
						'error' => 0,
						'message' =>'<span style="color:#78c028">Отправлено! Мы скоро позвоним вам</span>',
				));
			
			}else {
				$sql = 'SELECT * FROM actions WHERE id = '.$id.'';
				$action = $db->createCommand($sql)->queryRow();
			
				if (isset($action['meta_title']) && $action['meta_title'] != ''){
					$this->pageTitle=$action['meta_title'].'';
					Yii::app()->clientScript->registerMetaTag($action['meta_description'], 'description');
					Yii::app()->clientScript->registerMetaTag($action['meta_keywords'], 'keywords');
				} else
					$this->pageTitle=$action['name'].'';
				
				if (!isset($action['id']))
					throw new CHttpException(404,'Ой, такой страницы нет');
			
				$sql = 'SELECT p.*, c.uri as cat_uri FROM products p 
						INNER JOIN actions_category_product acp ON acp.prod_id = p.id 
						INNER JOIN  products_category pc ON pc.product_id = p.id 
						INNER JOIN categories c ON c.id = pc.category_id 
						WHERE acp.visibly = 1 AND acp.action_id = '.$id.' AND c.visibly = 1 AND p.visibly = 1 AND p.img != "" AND p.img != "|" GROUP by p.id ORDER by p.orders';
				$products = $db->createCommand($sql)->queryAll();
				$ProductSort = array();
				
				foreach($products as $K => $p) {
					$ProductSort[$p['id']] = $p;
				}
				
				$sql = 'SELECT p.*, c.uri as cat_uri FROM products p
						INNER JOIN actions_products ap ON ap.product_id = p.id
						INNER JOIN  products_category pc ON pc.product_id = p.id 
						INNER JOIN categories c ON c.id = pc.category_id 
						WHERE ap.visibly = 1 AND ap.action_id = '.$id.' AND c.visibly = 1 AND  p.visibly = 1 AND p.img != "" AND p.img != "|" GROUP by p.id ORDER by p.orders';
				$products2 = $db->createCommand($sql)->queryAll();
				
				foreach($products2 as $K => $p) {
					$ProductSort[$p['id']] = $p;
				}
				
				
				$this->render('view', array(
						'products' => $ProductSort,
						'action' => $action,
				));
			}
		}
	}
	
	
}