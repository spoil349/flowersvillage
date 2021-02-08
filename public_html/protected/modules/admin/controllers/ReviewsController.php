<?php

class ReviewsController extends Controller
{
	public $layout ='application.modules.admin.views.layouts.main';
	public $layoutPath ="protected/modules/admin/views/layouts";
	
	public function actionIndex($cat_uri = '') {
		$this->redirect('/admin/reviews/list/',array());
	}	
	
	public function actionList($cat_uri = '') {
	if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
		
			$this->render('list',array(
			 		'ARRitems' => $this->module->GetAllReviews(),					
			 	)
			 );
	}
	
	public function actionEdit($id = '', $cat_uri = '') {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
		
		if ($cat_uri == 'new') {
			
		} elseif ($id != '') {
		//$this->module->pre($this->module->GetProductWhithAll($id));
			$this->render('edit',array(
					'ARRitem' => $this->module->GetReviewWhithAll($id),
			)
			);

		}
	}
}
