<?php

class PagesController extends Controller
{
	public $layout ='application.modules.admin.views.layouts.main';
	public $layoutPath ="protected/modules/admin/views/layouts";
	
	public function actionIndex() {
		$this->redirect('/admin/pages/list/',array());
	}	
	
	public function actionList() {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
		
			$this->render('list',array(
			 		'ARRitems' => $this->module->GetAllPages(),
			 	)
			 );
	}
	
	public function actionNew() {
		$db = Yii::app()->db;
		
		$sql = 'SELECT id FROM pages Order by id DESC';
		$newNum = (int)$db->createCommand($sql)->queryScalar() + 1;
				
		$sql = 'INSERT INTO pages (name) VALUES ("Страница '.$newNum.'")';
		$db->createCommand($sql)->execute();
		$id = $db->getLastInsertId('pages');
		/*		
		$sql = 'SELECT id FROM features  WHERE tocart != "1" ';
		$features = $db->createCommand($sql)->queryAll();
		foreach($features as $K => $feature){
		
			$db = Yii::app()->db;
			$sql = 'INSERT  INTO  features_products (feature_id, visibly, product_id) VALUES (\''.$feature['id'].'\',\'1\',\''.$id.'\')';
			$cmd = $db->createCommand($sql)->execute();
		}
		*/
		$this->redirect('/admin/'.$this->id.'/edit/'.$id.'?new=1',array());
	}
	
	public function actionEdit($id) {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
				
			$ARRpage= $this->module->GetPageWithAll($id);
		
			$this->render('edit',array(
					'ARRpage' => $ARRpage,
				)
			);
	}
	
	public function actionSaveimg(){
	
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
	
		$dir = $_SERVER['DOCUMENT_ROOT'].'/uploads/pages/';
	
		$_FILES['file']['type'] = strtolower($_FILES['file']['type']);
	
		if ($_FILES['file']['type'] == 'image/png'
				|| $_FILES['file']['type'] == 'image/jpg'
				|| $_FILES['file']['type'] == 'image/gif'
				|| $_FILES['file']['type'] == 'image/jpeg'
				|| $_FILES['file']['type'] == 'image/pjpeg')
		{
			// setting file's mysterious name
			$filename = md5(date('YmdHis')).'.jpg';
			$file = $dir.$filename;
	
			// copying
			copy($_FILES['file']['tmp_name'], $file);
	
			// displaying file
			$array = array(
					'filelink' => '/uploads/pages/'.$filename
			);
	
			echo stripslashes(json_encode($array));
	
		}
	}
}
