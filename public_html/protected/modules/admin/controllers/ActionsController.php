<?php

class ActionsController extends Controller
{
	public $layout ='application.modules.admin.views.layouts.main';
	public $layoutPath ="protected/modules/admin/views/layouts";
	
	public function actionIndex($cat_uri = '') {
		$this->redirect('/admin/actions/list/',array());
	}
	
	
	public function actionList($cat_uri = '') {
		
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
		
		$ARR = $this->module->GetAllActions();
		
		$TypesActions = $this->module->GetTypesActions();
		$ARRTypes = array();
		foreach ($TypesActions as $K => $V) {
			$ARRTypes[$K] = $V;
			$ARRTypes[$K]['id'] = $V['type'];
		}
			$this->render('list',array(
					'ARRitems' => $ARR,
					'ARRTypes' => $ARRTypes,
				)
			);	
	}
	
	public function actionEdit($id) {
		
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
		
		$TypesActions = $this->module->GetTypesActions();
		$ARRTypes = array();
		foreach ($TypesActions as $K => $V) {
			$ARRTypes[$K] = $V;
			$ARRTypes[$K]['id'] = $V['type'];
		}
		
		$this->render('edit',array(
				'ARRAction' => $this->module->GetActionWithAll($id),
				'ARRTypes' => $ARRTypes,
				'TypesActions' => $TypesActions,
				'ARRCategories' => $this->module->GetAllCategories(),
		)
		);
	}
	public function actionNew() {
		$db = Yii::app()->db;
	
		$sql = 'INSERT INTO actions (name, type, visibly) VALUES ("Новая акция","product",1)';
		$db->createCommand($sql)->execute();
	
		$this->redirect('/admin/'.$this->id.'/edit/'.$db->getLastInsertId('actions').'?new=1',array());
	}
	
	public function actionAddimg() {
		
		
		function exit_status($str){
			echo $str;
			exit;
		}
	
		if(!Yii::app()->request->isPostRequest)
			exit_status('Error! Wrong HTTP method!');

		$pic = $_FILES['myFile'];
		preg_match('|\.\S+|', $pic['name'],$ARR);
		
		if($_FILES['myFile']['type'] == 'image/png' || $_FILES['myFile']['type'] == 'image/jpeg' || $_FILES['myFile']['type'] == 'image/gif'){
			echo 'Uncorrect format!';
			exit;
		}	
		$w = (int)$_GET['width'];
		$h = (int)$_GET['height'];
		$filename = md5(time().rand('1', '100000')).$ARR[0];
		$upload_dir_time = $_SERVER['DOCUMENT_ROOT'].'/uploads/';
		$upload_dir = $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$w.'x'.$h.'/';
		$dir ='/uploads/'.$w.'x'.$h.'/';
		
		$filename = str_replace("'", '',$filename);
		$filename = str_replace("\\", "",$filename);
		
		//echo ini_get('upload_max_filesize');
		//EA($pic);
		//echo $pic['tmp_name'].' -> '. $upload_dir_time.$filename;
		if(move_uploaded_file($pic['tmp_name'], $upload_dir_time.$filename)){
			$thumb = new Imagick($upload_dir_time.$filename);
			
			$thumb->setImageCompression(Imagick::COMPRESSION_JPEG);
			$thumb->setImageCompressionQuality(90);
			$thumb->setInterlaceScheme(Imagick::INTERLACE_PLANE);
				
				
			if(!is_dir($upload_dir)) {
				mkdir($upload_dir);
			}
			$image = new Imagick();
			$image->newImage($w, $h,  new ImagickPixel('white'));
			$image->setImageFormat($thumb->getImageFormat());
			
			
			$WidthProp = $w / $h ;
			$HeightProp = $thumb->getImageWidth() / $thumb->getImageHeight();
					
			$thumb->cropThumbnailImage($w,$h);

			$image->compositeImage( $thumb, Imagick::COMPOSITE_DEFAULT, ($image->getImageWidth() - $thumb->getImageWidth())/2, ($image->getImageHeight() - $thumb->getImageHeight())/2 );
			
			$image->unsharpMaskImage(0 , 0.53 , 1 , 0.05);
			$image->writeImage( $upload_dir.$filename);
			$image->destroy();
			exit_status($filename);
		} else {
			exit_status('Error! Can`t copy image');
		}
	}
}
