<?php

class ProductsController extends Controller
{
	public $layout ='application.modules.admin.views.layouts.main';

	public function actionIndex($cat_uri = '') {
		$this->redirect('/admin/products/list/',array());
	}	
	
	public function actionList($id = '') {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
		
		if ($id == ''){
			$this->render('list',array(
			 		'ARRitems' => $this->module->GetAllProducts(),
			 		'ARRcat' =>$this->module->GetAllCategories(),
					'ARRaction' => $this->module->GetAllActions(),
					'Catalog' => $this->module->GetSectionsWithCategory(),
					'id' => $id
						
			 	)
			 );
		} else {
			$this->render('list',array(
					'ARRitems' => $this->module->GetCategoryWhithAllProducts($id),
					'ARRcat' =>$this->module->GetAllCategories(),
					'ARRaction' => $this->module->GetAllActions(),
					'Catalog' => $this->module->GetSectionsWithCategory(),
					'id' => $id
						
				)
			);
		}
	}
	
	public function actionEdit($id = '', $cat_uri = '') {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
		
		if ($cat_uri == 'new') {
			
		} elseif ($id != '') {
			
			$ARRitem = $this->module->GetProductWhithAll($id);
			
			$this->render('edit',array(
					'ARRitem' => $ARRitem,
					'ARRcat' =>$this->module->GetAllCategories(),
					'ARRaction' => $this->module->GetAllActions(),
					'Catalog' => $this->module->GetSectionsWithCategory(),
					'id' => 'aaa',
			)
			);

		}
	}
	
	public function actionNew() {
		$db = Yii::app()->db;
		
		$sql = 'SELECT id FROM products Order by id DESC';
		$newNum = (int)$db->createCommand($sql)->queryScalar() + 1;
				
		$sql = 'INSERT INTO products (name, price, visibly) VALUES ("Букет '.$newNum.'",0,1)';
		$db->createCommand($sql)->execute();
		$id = $db->getLastInsertId('products');
				
		$sql = 'SELECT id FROM features  WHERE tocart != "1" ';
		$features = $db->createCommand($sql)->queryAll();
		foreach($features as $K => $feature){
		
			$db = Yii::app()->db;
			$sql = 'INSERT  INTO  features_products (feature_id, visibly, product_id) VALUES (\''.$feature['id'].'\',\'1\',\''.$id.'\')';
			$cmd = $db->createCommand($sql)->execute();
		}
		
		$this->redirect('/admin/'.$this->id.'/edit/'.$id,array());//.'?new=1'
	}
}
