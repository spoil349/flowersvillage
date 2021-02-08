<?php

class UpdateController extends Controller
{
	public function actionIndex() {
		
		if(strtolower($_SERVER['REQUEST_METHOD']) == 'post'  &&  Yii::app()->user->getState('auth')){
			
			
			if ($_POST['stat'] == 'edit_feature_product_price' ) {
				
				Yii::app()->db->createCommand()->delete('feature_product_price', 'feature_id = :feature_id AND product_id = :id', array(':id' => $_POST['id'], ':feature_id' => $_POST['feature_id']));
				
				$ArrPrice = explode ('|', $_POST['line_price']);
				$ArrPrice = array_diff($ArrPrice, array(''));
				$defPrice = 10000000;
				$arrVal = array();
				foreach ($ArrPrice as $K => $V) {
					$onePrice = explode(':', $V);
					$price = $price = preg_replace("/\D/", "", $onePrice[1]);
					$arrVal[] = $onePrice[0];
					if ($onePrice[0] != '' && $price != ''){
						$db = Yii::app()->db;
						$sql = 'INSERT  INTO  feature_product_price (product_id, feature_id, value, price) VALUES (\''.$_POST['id'].'\', \''.$_POST['feature_id'].'\',\''.$onePrice[0].'\',\''.$price.'\')';
						$cmd = $db->createCommand($sql);
						$cmd->execute();
					}
					
					
					if ((int)$price < $defPrice) {
						$defPrice = (int)$price;
					}
				}
				Yii::app()->db->createCommand()->update('features_products', array( 'value'=> implode('|', $arrVal)), 'product_id=:id AND feature_id = :feature_id', array(':id' => $_POST['id'], ':feature_id' => $_POST['feature_id']));
				Yii::app()->db->createCommand()->update('products', array( 'price'=> $defPrice), 'id=:id', array(':id' => $_POST['id']));
				
				
			} elseif	($_POST['stat'] == 'edit_feachers_categories' ) {
				
					$ARR = explode (',', $_POST['value']);
					
					Yii::app()->db->createCommand()->update('features_category', array( 'visibly'=> 0), 'feature_id=:id', array(':id' => (int)$_POST['id']));
					Yii::app()->db->createCommand()->update('features_products', array( 'visibly'=> 0), 'feature_id=:id', array(':id' => (int)$_POST['id']));
					
					if ($ARR[0] != '') {
						
							foreach ($ARR as $V) {
									$cat_id = str_replace('cat_', '', $V);
									
									$ARR = Yii::app()->db->createCommand()
									->select('id')
									->from('features_category')
									->where('cat_id='.(int)$cat_id.' AND feature_id= '.(int)$_POST['id'].'')
									->queryRow();
									
									 if(isset($ARR['id'])) {
									 		Yii::app()->db->createCommand()->update('features_category', array( 'visibly'=> 1), 'feature_id=:id AND cat_id='.(int)$cat_id.'', array(':id' => (int)$_POST['id']));
									 		Yii::app()->db->createCommand()->update('features_products', array( 'visibly'=> 1), 'feature_id=:id AND cat_id='.(int)$cat_id.'', array(':id' => (int)$_POST['id']));
			
									 } else {
									 	
										 	$db = Yii::app()->db;
										 	$sql = 'INSERT  INTO  features_category (cat_id, feature_id, visibly) VALUES (\''.$cat_id.'\', \''.$_POST['id'].'\',\'1\')';
										 	$cmd = $db->createCommand($sql);
										 	$cmd->execute();
										 
										 	$ARRprod = Yii::app()->db->createCommand()
											->select('t1.id')
											->from('products as t1, products_category as t2')
											->where('t2.category_id='.(int)$cat_id.' AND t1.id = t2.product_id')
											->queryAll();
										 	
										 	if (isset($ARRprod[0])) {
											 		foreach ($ARRprod as $V) {
														 	$db = Yii::app()->db;
														 	$sql = 'INSERT  INTO  features_products (cat_id, feature_id, visibly, product_id) VALUES (\''.$cat_id.'\', \''.$_POST['id'].'\',\'1\',\''.$V['id'].'\')';
														 	$cmd = $db->createCommand($sql);
														 	$cmd->execute();
											 		}
										 	}
									 	
									 	
									 	
									 }
							}
					
					}
				
			} elseif ($_POST['stat'] == 'addfeatures_tocategory'){
				
				$ARR = explode (',', $_POST['value']);
				
				Yii::app()->db->createCommand()->update('features_category', array( 'visibly'=> 0), 'cat_id=:id', array(':id' => (int)$_POST['id']));
				Yii::app()->db->createCommand()->update('features_products', array( 'visibly'=> 0), 'cat_id=:id', array(':id' => (int)$_POST['id']));
				
				if ($ARR[0] != 'null') {
							
						$cat_id = $_POST['id'];
						foreach ($ARR as $V) {
								
								$features_id = $V;
								
								$ARR = Yii::app()->db->createCommand()
								->select('id')
								->from('features_category')
								->where('cat_id='.(int)$cat_id.' AND feature_id= '.(int)$features_id.'')
								->queryRow();
							
								if(isset($ARR['id'])) {
										Yii::app()->db->createCommand()->update('features_category', array( 'visibly'=> 1), 'feature_id=:id AND cat_id='.(int)$cat_id.'', array(':id' => (int)$features_id));
										Yii::app()->db->createCommand()->update('features_products', array( 'visibly'=> 1), 'feature_id=:id AND cat_id='.(int)$cat_id.'', array(':id' => (int)$features_id));
							
								} else {
							
										$db = Yii::app()->db;
										$sql = 'INSERT  INTO  features_category (cat_id, feature_id, visibly) VALUES (\''.$cat_id.'\', \''.$features_id.'\',\'1\')';
										$cmd = $db->createCommand($sql);
										$cmd->execute();
											
										$ARRprod = Yii::app()->db->createCommand()
										->select('t1.id')
										->from('products as t1, products_category as t2')
										->where('t2.category_id='.(int)$cat_id.' AND t1.id = t2.product_id')
										->queryAll();
								
										if (isset($ARRprod[0])) {
												foreach ($ARRprod as $V) {
														$db = Yii::app()->db;
														$sql = 'INSERT  INTO  features_products (cat_id, feature_id, visibly, product_id) VALUES (\''.$cat_id.'\', \''.$features_id.'\',\'1\',\''.$V['id'].'\')';
														$cmd = $db->createCommand($sql);
														$cmd->execute();
												}
										}
							
							
							
								}
						}
					
				}	

			} elseif ($_POST['stat'] == 'edit_actions_categories'){	
				$ARR = explode (',', $_POST['value']);
					
				Yii::app()->db->createCommand()->delete( 'actions_category', 'action_id=:id', array(':id' => $_POST['id']));
				Yii::app()->db->createCommand()->delete( 'actions_category_product', 'action_id=:id', array(':id' => $_POST['id']));
		
				if ($ARR[0] != '' && $_POST['value'] != 'null' ) {
				
					foreach ($ARR as $V) {
							$cat_id = str_replace('cat_', '', $V);
							
							$db = Yii::app()->db;
							$sql = 'INSERT  INTO  actions_category (cat_id, action_id, visibly) VALUES (\''.$cat_id.'\', \''.$_POST['id'].'\',\'1\')';
							$cmd = $db->createCommand($sql);
							$cmd->execute();
					
							$ARRprod = Yii::app()->db->createCommand()
							->select('t1.id')
							->from('products as t1, products_category as t2')
							->where('t2.category_id='.(int)$cat_id.' AND t1.id = t2.product_id')
							->queryAll();
							//print_r($ARRprod);
							if (isset($ARRprod[0])) {
								foreach ($ARRprod as $V) {
									
									$ARR_ACP = Yii::app()->db->createCommand()
										->select('id')
										->from('actions_category_product')
										->where('prod_id='.$V['id'].' AND action_id= '.$_POST['id'].'')
										->queryRow();
									
									if(isset($ARR_ACP['id'])) {
									} else {
										
										$db = Yii::app()->db;
										$sql = 'INSERT  INTO  actions_category_product (action_id, prod_id, visibly) VALUES (\''.$_POST['id'].'\', \''.$V['id'].'\',\'1\')';
										$cmd = $db->createCommand($sql);
										$cmd->execute();
									}
								}
							}
					}
						
				}
				
			} elseif ($_POST['stat'] == 'addactions_tocategory'){
				
				$ARR = explode (',', $_POST['value']);
				$cat_id = $_POST['id'];
				
				$ARRprod = Yii::app()->db->createCommand()
				->select('t1.id')
				->from('products as t1, products_category as t2')
				->where('t2.category_id='.(int)$cat_id.' AND t1.id = t2.product_id')
				->queryAll();
				
				$ProdIds = array();
				foreach($ARRprod as $p) {
					$ProdIds[] = $p['id'];
				}
			
				Yii::app()->db->createCommand()->delete( 'actions_category', 'cat_id=:id', array(':id' => $_POST['id']));
				if (count($ProdIds) > 0){
					Yii::app()->db->createCommand()->delete( 'actions_category_product', 'prod_id IN ('.implode(',', $ProdIds).')');
				}
				
				if ($ARR[0] != '' && $_POST['value'] != 'null' ) {
										
						foreach ($ARR as $V) {
							$InsertValues = array();	
							
							$db = Yii::app()->db;
							$sql = 'INSERT  INTO  actions_category (cat_id, action_id, visibly) VALUES (\''.$cat_id.'\', \''.$V.'\',\'1\')';
							$cmd = $db->createCommand($sql);
							$cmd->execute();
							
							foreach ($ProdIds as $K => $p_id) {
								$InsertValues[] = '(\''.$V.'\', \''.$p_id.'\',\'1\')';
							}
							if (count($InsertValues) > 0) {
								$db = Yii::app()->db;
								$sql = 'INSERT  INTO  actions_category_product (action_id, prod_id, visibly) VALUES '.implode(', ', $InsertValues).'';
								$cmd = $db->createCommand($sql);
								$cmd->execute();
							}
						}
				}
				
			} elseif ($_POST['stat'] == 'editaction_toproduct' ) {
				
				$ARR = explode (',', $_POST['value']);
				
				Yii::app()->db->createCommand()->delete( 'actions_products', 'product_id=:id', array(':id' => $_POST['id']));
				Yii::app()->db->createCommand()->delete( 'actions_category_product', 'prod_id=:id', array(':id' => $_POST['id']));
				
				if ($ARR[0] != '' && $_POST['value'] != 'null' ) {
					foreach ($ARR as $V) {
				
						$db = Yii::app()->db;
						$sql = 'INSERT  INTO  actions_products (product_id, action_id, visibly) VALUES (\''.$_POST['id'].'\', \''.$V.'\',\'1\')';
						$cmd = $db->createCommand($sql);
						$cmd->execute();
					}
				}
				
			} elseif ($_POST['stat'] == 'editfield' ) {
				
				
					
				if ($_POST['field'] == 'cat_id' && $_POST['f'] == 'products' ) {
						$db = Yii::app()->db;
						//Yii::app()->db->createCommand()->update($_POST['f'], array( $_POST['field']=> $_POST['value']), 'id=:id', array(':id' => $_POST['id']));
						
						$sql = 'DELETE FROM  products_category WHERE product_id = '.$_POST['id'].'';
						$db->createCommand($sql)->execute();
						$ARRnewCat = explode(',', $_POST['value']);						
						$Arrcatinsert = array();
						foreach($ARRnewCat as $V) {
							if ($V !='' && $V !='null' && $V != null) $Arrcatinsert[] = '('.$_POST['id'].','.$V.')';
						}
						if (count($Arrcatinsert) > 0){
							$sql = 'INSERT INTO products_category (product_id, category_id) VALUES '.implode(',', $Arrcatinsert).'';
							$db->createCommand($sql)->execute();
						}
						Yii::app()->db->createCommand()->update('features_products', array( 'visibly'=> 0), 'product_id=:id', array(':id' => (int)$_POST['id']));
								
						
						foreach($ARRnewCat as $category_id) {
							
							$Product_features = Yii::app()->db->createCommand()
							->select('feature_id')
							->from('features_products')
							->where('product_id='.$_POST['id'].'')
							->queryALL();
							
							$ARR = Yii::app()->db->createCommand()
							->select('feature_id, visibly')
							->from('features_category')
							->where('cat_id='.$category_id.'')
							->queryALL();
							
							foreach($ARR as $K => $V) {
								$Check = false;
								
								foreach ( $Product_features as $k2 => $v2) {
									if ($v2['feature_id'] == $V['feature_id']) {
										$Check = true;
									}
								}
								if ($Check) {
									Yii::app()->db->createCommand()->update('features_products', array( 'visibly'=> $V['visibly']), 'product_id=:id AND feature_id = :feature_id', array(':id' => $_POST['id'], ':feature_id' => $V['feature_id']));
								} else {
									$sql = 'INSERT  INTO  features_products (cat_id, feature_id, product_id, visibly) VALUES (\''.$category_id.'\', \''.$V['feature_id'].'\', \''.$_POST['id'].'\',\''.$V['visibly'].'\')';
									$db->createCommand($sql)->execute();
								}
							}
										
						}
						
				 } elseif ($_POST['field'] == 'others' && $_POST['f'] == 'others_products' ) {
				 		
				 		$ARR = Yii::app()->db->createCommand()
					 	->select('id')
					 	->from('others_products')
					 	->where('prod_id='.$_POST['id'].'')
					 	->queryRow();
				 	
				 		if (isset($ARR['id'])) {
				 			Yii::app()->db->createCommand()->update('others_products', array('others' => $_POST['value']), 'prod_id=:id', array(':id' => $_POST['id']));
				 		} else {
				 			$db = Yii::app()->db;
				 			$sql = 'INSERT  INTO  others_products (prod_id, others) VALUES (\''.$_POST['id'].'\', \''.$_POST['value'].'\')';
				 			$cmd = $db->createCommand($sql);
				 			$cmd->execute();
				 		}
				 } elseif ($_POST['field'] == 'hot' && $_POST['f'] == 'products' && $_POST['value'] == 1 ) {		
				 	Yii::app()->db->createCommand()->update($_POST['f'], array( $_POST['field']=> $_POST['value']), 'id=:id', array(':id' => $_POST['id']));
				 	
			 	 } elseif ($_POST['field'] == 'price') {		
	
			 	 	$price = preg_replace("/\D/","",$_POST['value']);
			 	 	Yii::app()->db->createCommand()->update($_POST['f'], array( $_POST['field']=> $price), 'id=:id', array(':id' => $_POST['id']));
			 	 	
			 	 	if ($_POST['f'] == 'products') {
			 	 		$ARRprice = Yii::app()->db->createCommand()
			 	 		->select('id, price')
			 	 		->from('feature_product_price')
			 	 		->where('product_id = '.$_POST['id'].'  order by price ASC')
			 	 		->queryRow();
			 	 		
			 	 		if (isset($ARRprice['id'])){
			 	 			Yii::app()->db->createCommand()->update('feature_product_price', array( 'price'=> $price), 'id=:id', array(':id' => $ARRprice['id']));
			 	 		}
			 	 	}
				 	
				 } else {
				 	
				 		Yii::app()->db->createCommand()->update($_POST['f'], array( $_POST['field']=> $_POST['value']), 'id=:id', array(':id' => $_POST['id']));
				 }
			
			
			
			
			
			} elseif ($_POST['stat'] == 'sort'){
				$ArrCat = explode('|', $_POST['sort_line']);
				foreach ($ArrCat as $V){
					if ($V!= ''){
						$Arrsort = explode('-', $V);
						Yii::app()->db->createCommand()->update($_POST['f'], array( 'orders'=> $Arrsort[1]), 'id=:id', array(':id' => $Arrsort[0]));
					}
				}
			
			
			
			
			
			} elseif ($_POST['stat'] == 'addnew'){
				
				$db = Yii::app()->db;
				
				
				if ($_POST['f'] == 'categories') {
					$_POST['uri'] = $this->module->translit($_POST['uri']);
					if (isset($_POST['need'])) {
						echo $_POST['uri'];
					}
				}
				
				
				
				$line_field = array();
				$line_value = array();
				
							
					foreach ($_POST as $K => $V) {
						if ($K != 'stat' && $K != 'f' && $K != 'need' ) {
							$line_field[] = $K;
							$line_value[] = "'".$V."'";
						}
					}
					if ($_POST['f'] == 'reviews'){
						$line_field[] = 'ts';
						$line_value[] = "".time()."";
					}
					
					$sql = 'INSERT  INTO  '.$_POST['f'] .' ('.implode(',', $line_field).') VALUES ('.implode(',', $line_value).')';
					$cmd = $db->createCommand($sql);
					$cmd->execute();

				if ($_POST['f'] == 'categories') {
					$ARROne = Yii::app()->db->createCommand()
					->select('id')
					->from('features')
					->where('tocart="1" ')
					->queryRow();
					
					$_ID = Yii::app()->db->getLastInsertID(''.$_POST['f'].'');
					
					if (!isset($_POST['need'])) {
						echo $_ID;
					}
					
					$sql = 'INSERT  INTO  features_category (cat_id, feature_id, visibly ) VALUES (\''.$_ID.'\', \''.$ARROne['id'].'\',\'1\')';
					$cmd = $db->createCommand($sql);
					$cmd->execute();
				} elseif ($_POST['f'] == 'products'){
					
					echo $product_id = Yii::app()->db->getLastInsertID(''.$_POST['f'].'');
					
					$arrCategory = explode(',', $_POST['cat_id']);
					$arrcatSelect = array();
					$arrcatInsert = array();
					
					foreach ($arrCategory as $cat) {
						if ($cat!= '' && $cat!= 'null' && $cat!= null) {
							$arrcatSelect[] = 't2.cat_id = '.$cat;
							$arrcatInsert[] = '('.$product_id.','.$cat.')';
						}
					}
					if (count($arrcatInsert) > 0){
						$sql = 'INSERT  INTO  products_category (product_id, category_id) VALUES '.implode(',', $arrcatInsert).'';
						$db->createCommand($sql)->execute();
					}
					
					if (count($arrcatSelect) > 0){
						$ArrcatFeat = Yii::app()->db->createCommand()
						->select('t1.*')
						->from('features as t1, features_category as t2 ')
						->where('t1.id = t2.feature_id AND ( '.implode(' OR ',$arrcatSelect).')')
						->queryALL();
						
						foreach($ArrcatFeat as $K => $V) {
							
								$sql = 'INSERT  INTO  features_products (product_id, feature_id, cat_id, visibly) VALUES (\''.$product_id.'\', \''.$V['id'].'\', \''.$_POST['cat_id'].'\',\'1\')';
			 					$cmd = $db->createCommand($sql);
			 					$cmd->execute();
						}
					}
					
				} else {
					if (!isset($_POST['need'])) {
						echo $product_id = Yii::app()->db->getLastInsertID(''.$_POST['f'].'').'';
					}
					
				}
					
				
			
			} elseif ($_POST['stat'] == 'delete'){
				if ($_POST['f'] == 'features') { 
					$ARROne = Yii::app()->db->createCommand()
					->select('tocart')
					->from('features')
					->where('id='.$_POST['id'].' ')
					->queryRow();
					
					if ($ARROne['tocart'] != '1') {
						Yii::app()->db->createCommand()->delete($_POST['f'], 'id=:id', array(':id' => $_POST['id']));
					}
				} else {
					Yii::app()->db->createCommand()->delete($_POST['f'], 'id=:id', array(':id' => $_POST['id']));
				}
				
				if ($_POST['f'] == 'products') {
					Yii::app()->db->createCommand()->delete('features_products', 'product_id=:id', array(':id' => $_POST['id']));
				}
				if ($_POST['f'] == 'features') {
					Yii::app()->db->createCommand()->delete('features_products', 'feature_id=:id', array(':id' => $_POST['id']));
					Yii::app()->db->createCommand()->delete('features_category', 'feature_id=:id', array(':id' => $_POST['id']));
				}
				if ($_POST['f'] == 'categories') {
					Yii::app()->db->createCommand()->delete('features_category', 'cat_id=:id', array(':id' => $_POST['id']));
				}
				if ($_POST['f'] == 'actions') {
					Yii::app()->db->createCommand()->delete('actions_products', 'feature_id=:id', array(':id' => $_POST['id']));
					Yii::app()->db->createCommand()->delete('actions_category', 'feature_id=:id', array(':id' => $_POST['id']));
				}
			
			}
			
			
		
		
		} 
	}
		
	public function actionProductpopup() {
	
		if(strtolower($_SERVER['REQUEST_METHOD']) == 'post' &&  Yii::app()->user->getState('auth')){
			
			if (isset($_POST['cat']) && $_POST['stat'] == 'start'){
				
				$cat = $_POST['cat'];
				
				$Arrcat = Yii::app()->db->createCommand()
				->select('*')
				->from('categories')
				->where('id!="" ORDER BY orders ASC ')
				->queryALL();
				
				$i= 1;
				$MenuCat = '';
				foreach ($Arrcat as $k=> $V){
					$style = '';
					if ($cat == '' && $k == 0) {			
						$cat_id = $V['id']; $style='menu_select';
					}else {
						if ($cat == $V['uri']){ $cat_id = $V['id']; $style='menu_select';}
					}
					$MenuCat .= '<div class="one_left_menu '.$style.'" id="'.$V['id'].'" >'.$V['name'].'</div>';
					$i++;
				}
				echo '<div class="popup_left">'.$MenuCat.'</div>';
			
			
			}else {
				$cat_id = $_POST['cat_id'];
			}
			
			$sql = 'SELECT p.* FROM products p INNER JOIN  products_category pc ON pc.product_id = p.id  WHERE pc.category_id = '.$cat_id.' GROUP by p.id ORDER by p.orders';
			$Array = Yii::app()->db->createCommand($sql)->queryAll();
			
			
			if (count($Array) === 0 ){
					
				echo  '<div class="popup_right">В этой категории нет товаров</div><div class="br"></div>';
			}
			$n = 1;
			$line = '';
			foreach ($Array as $k => $V){
			
				
				$select_size = '';

				$Arrimg = explode('|', $V['img']);
				$Arrimg = array_diff($Arrimg, array(''));
				if (count($Arrimg) > 0){
					$line .= '<div class="popup_one_products " id="'.$V['id'].'">
									<div class="popup_one_products_img"><img src="/uploads/81x84/'.current($Arrimg).'"></div>
									<div class="popup_one_products_name">'.$V['name'].'</div>
									'.$select_size.'
							</div>
					';
				}
			}
			if (count($Array) != 0 ){
				echo '<div class="popup_right">'.$line.'</div><div class="br"></div>';
			}
			
		}
	}
	
	
}
