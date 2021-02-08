<?php

class CategoriesController extends Controller
{
	public $layout ='application.modules.admin.views.layouts.main';
	public $layoutPath ="protected/modules/admin/views/layouts";
	
	public function actionIndex($cat_uri = '') {
		$this->redirect('/admin/categories/list/',array());
	}	
	
	public function actionList($cat_uri = '') {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());	
		
			$this->render('list',array(
			 		'ARRitems' => $this->module->GetAllCategories(),
					'ARRsection' => $this->module->GetAllSections(),
			 	)
			 );
	}
	
	public function actionEdit($id) {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
		
			$ARRCategory = $this->module->GetCategoryWithAll($id);
		
			$this->render('edit',array(
					'ARRCategory' => $ARRCategory,
					'ARRsection' => $this->module->GetAllSections(),
					'ARRFeatures' => $this->module->GetAllFeatures(),
					'ARRActions' => $this->module->GetAllActions(),
					'countProduct' => count($this->module->GetCategoryWhithAllProducts($id)),
			)
			);
	}
	
	public function actionNew() {
		$db = Yii::app()->db;
	
		$sql = 'SELECT id FROM categories Order by id DESC';
		$newNum = (int)$db->createCommand($sql)->queryScalar() + 1;
	
		$sql = 'INSERT INTO categories (name,uri , visibly) VALUES ("Новая категрия'.$newNum.'", "category'.$newNum.'",1)';
		$db->createCommand($sql)->execute();
	
		$this->redirect('/admin/'.$this->id.'/edit/'.$db->getLastInsertId('categories').'?new=1',array());
	}
}
