<?php

class FeaturesController extends Controller
{
	public $layout ='application.modules.admin.views.layouts.main';
	public $layoutPath ="protected/modules/admin/views/layouts";
	
	public function actionIndex($cat_uri = '') {
		$this->redirect('/admin/features/list/',array());
	}
	
	
	public function actionList($cat_uri = '') {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
				
		$ARR = $this->module->GetAllFeatures();
		$ARRitems = array();
		if ($cat_uri == 'admin'){
			foreach($ARR as $V) {
				if ($V['admin'] == 1) $ARRitems[] = $V;
			}	
			
			$this->render('list',array(
					'ARRitems' => $ARRitems,
					'cat_uri'=> $cat_uri,
				)
			);
		}elseif ($cat_uri == 'users') {
			foreach($ARR as $V) {
				if ($V['admin'] == 0) $ARRitems[] = $V;
			}
			
			$this->render('list',array(
					'ARRitems' => $ARRitems,
					'cat_uri'=> $cat_uri,
				)
			);
		} else {
			$this->render('list',array(
					'ARRitems' => $ARR,
					'cat_uri'=> $cat_uri,
				)
			);
		}
		
	}
	
	public function actionEdit($id) {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
		
		$this->render('edit',array(
				'ARRFeature' => $this->module->GetFeatureWithAll($id),
				'ARRCategories' => $this->module->GetAllCategories(),
				'TypesFeatures' => $this->module->GetTypesFeatures(),
		)
		);
	}
	
	public function actionNew() {
		$db = Yii::app()->db;
	
		$sql = 'INSERT INTO features (name, visibly) VALUES ("Новое свойство",1)';
		$db->createCommand($sql)->execute();
	
		$this->redirect('/admin/'.$this->id.'/edit/'.$db->getLastInsertId('features').'?new=1',array());
	}
}
