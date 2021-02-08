<?php
class GetInstagramItems {
	
	private $ArrayAdded = array();
	private $db = '';
	private $Arrlog = array();
	private $count = 0;
	
	public function GetLast() {
		
		$this->getArrayAdded();
		
		$instagram = Yii::app()->instagram->getInstagramApp();
		$accessToken = Yii::app()->params['instagram_token'];
		$instagram->setAccessToken($accessToken);
		
		$Array_first = $instagram->getUserRecent(Yii::app()->params['instagram_id']);
		
		
		
		$this->ParseItems($Array_first);
		
		EA($this->Arrlog);
		
 		return $this->Arrlog;
	}
	
	public static function GetAll() {
	
		$this->getArrayAdded();
		
		$instagram = Yii::app()->instagram->getInstagramApp();
		$accessToken = Yii::app()->params['instagram_token'];
		$instagram->setAccessToken($accessToken);
		
		$Array_first = $instagram->getUserRecent(Yii::app()->params['instagram_id']);
		$this->Arrlog[] = $this->ParseItems($Array_first);
		
		if (isset($Array_first['pagination']['next_max_id'])) {
			$array = array();
			$check_next = 1;
			$next_id = $Array_first['pagination']['next_max_id'];
			while ($check_next == 1) {
				$array = $instagram->getUserRecent(Yii::app()->params['instagram_id'], $next_id);
				if (isset($array['pagination']['next_max_id'])) {
					$next_id = $array['pagination']['next_max_id'];
					$check_next = 1;
				} else {
					$check_next = 0;
						
				}
				$this->ParseItems($array);
		
			}
		}
		
		return CJSON::encode($this->$Arrlog);
	}
	
	
	private function ParseItems($ItemsPage) {
		foreach($ItemsPage['data'] as $k => $item){
			$this->Arrlog[] = $k.' -> '.$this->ParseOneItem($item);			
		}
	}
	
	private function ParseOneItem($item) {
		$token = md5($item['images']['standard_resolution']['url']);
		
		if (!isset($this->ArrayAdded[$token])){
			$img  = '/inst/'.$token.'.jpg';
			
			
			if(isset($item['caption']['text'])){
				$Arrcaption = explode(',' , str_replace('#'.Yii::app()->params['instagram_select_tag'], '', $item['caption']['text']));
				
			}else {
				$Arrcaption = array();
			}
		
			$name = '';
			$price = '';
			$category = '';
			$rating = 5;
		
			
			
			if (isset($Arrcaption[0]) && $Arrcaption[0] != ''){
				$name = trim(str_replace('#', '', $Arrcaption[0]));
				echo 111;
			} else {
				$db = Yii::app()->db;
				$sql = 'SELECT id FROM products Order by id DESC';
				$newNum = (int)$db->createCommand($sql)->queryScalar() + 1;
				$name = 'Новый товар '.$newNum;
				echo 222;
			}
			if (isset($Arrcaption[1]) && $Arrcaption[1] != '')
				$price = trim(preg_replace("/[^0-9]/","", $Arrcaption[1]));
			else
				$price = 0;
			if (isset($Arrcaption[2]) && $Arrcaption[2] != '')
				$category = trim(str_replace('#', '', $Arrcaption[2]));
			else 
				$category = '';
		
			if ($name == '') {
				return 'error. Name is empty';
			}
			
			$sql = 'INSERT INTO products (name, instagram_hash, price, cat_id, rating, orders, img, visibly ) VALUES ("'.$name.'", "'.$token.'", '.$price.', 0, '.$rating.', 1, "'.$img.'", 1)';
			$this->db->createCommand($sql)->execute();
			$id = $this->db->getLastInsertId('products');
			
			if ($category != ''){
				
				$sql = 'SELECT id FROM categories WHERE LOWER(name) LIKE "'.strtolower($category).'" ';
				$category = $this->db->createCommand($sql)->queryRow();
				if (!isset($category['id'])){
					$category['id']= 84;
				}
			
				$sql = 'SELECT feature_id FROM features_category WHERE cat_id = '.$category['id'].' AND visibly = 1';
				$features = $this->db->createCommand($sql)->queryAll();
		
				$sql = 'INSERT INTO products_category (product_id, category_id) VALUES ("'.$id.'", '.$category['id'].')';
				$this->db->createCommand($sql)->execute();
			
				$Insetfeature = array();
				foreach ($features as $f) {
					$Insetfeature[] = '('.$id.', '.$f['feature_id'].', '.$category['id'].',1)';
				}
				if (count($Insetfeature) > 0) {
					$sql = 'INSERT INTO features_products (product_id, feature_id, cat_id, visibly) VALUES '.implode(',', $Insetfeature).'';
					$this->db->createCommand($sql)->execute();
				}
			
			}
		
			if( !file_exists($_SERVER['DOCUMENT_ROOT'].'uploads/612x612'.$img) ){
				copy($item['images']['standard_resolution']['url'], $_SERVER['DOCUMENT_ROOT'].'/uploads/612x612'.$img);
				$this->UploadInstagramPhotoforSizes($img);
				return 'ok. Uploaded';
			}
				
		} else{
			return 'nothing. Allready exsists';
		}
	}
	
	
	private function getArrayAdded(){
		
		$this->db = Yii::app()->db;
		$sql = 'SELECT id, instagram_hash FROM products WHERE instagram_hash != ""';
		$products = $this->db->createCommand($sql)->queryAll();
		
		foreach($products as $pr)
			$this->ArrayAdded[$pr['instagram_hash']] = $pr['id'];		
	}
	
	function UploadInstagramPhotoforSizes($file) {
	
		$WidthuploadARR[] 	= array(460, 		460, 	'460x460');
		$WidthuploadARR[] 	= array(300, 		300, 	'300x300');
		$WidthuploadARR[] 	= array(100, 		100, 	'100x100');
		$WidthuploadARR[] 	= array(300, 		300, 	'200x200');
		$WidthuploadARR[] 	= array(81, 		84, 	'81x84');
	
		$upload_dir = $_SERVER['DOCUMENT_ROOT'].'/uploads/{size}';
	
		if($thumb = new Imagick($_SERVER['DOCUMENT_ROOT'].'/uploads/612x612'.$file)) {

			
			foreach ($WidthuploadARR as $K => $V) {
				$dir = str_replace('{size}', $V[2], $upload_dir);
				$thumb->cropThumbnailImage($V[0],$V[1]);
					
				$thumb->unsharpMaskImage(0 , 0.53 , 1 , 0.05);
				$thumb->setInterlaceScheme(Imagick::INTERLACE_PLANE);
	
				$thumb->writeImage( $dir.$file);
	
	
			}
	
			$thumb->destroy();
		}
	}
	
}