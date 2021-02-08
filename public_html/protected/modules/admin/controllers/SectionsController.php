<?php

class SectionsController extends Controller
{
	public $layout ='application.modules.admin.views.layouts.main';
	
	public function actionIndex($cat_uri = '') {
		$this->redirect('/admin/sections/list/',array());
	}	
	
	public function actionList($cat_uri = '') {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());	
		
			$this->render('list',array(
			 		'ARRitems' => $this->module->GetAllSections(),
			 	)
			 );
	}
	
	public function actionEdit($id) {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
		
			$ARRsection= $this->module->GetSectionWithAll($id);
		
			$this->render('edit',array(
					'ARRsection' => $ARRsection,
			));
	}
}
