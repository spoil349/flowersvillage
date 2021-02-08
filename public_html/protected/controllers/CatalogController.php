<?php

class CatalogController extends Controller
{

	public $layout = 'main';
	
	public function actionIndex($uri = '', $id= '')
	{
		
		
		
		$db = Yii::app()->db;
		if($id == ''){

			if ($uri != ''){
			
				$sql = 'SELECT c.*, f.name as feature_name, f.variants as feature_variants FROM categories c LEFT JOIN features_category fc ON fc.cat_id = c.id LEFT JOIN features f ON fc.feature_id = f.id  WHERE  f.type="multiselect" AND f.visibly = 1 AND fc.visibly = 1 AND c.hidden = 0 AND c.uri = "'.$uri.'" GROUP by c.id ORDER by f.id ASC';//AND  c.visibly = 1 
				$category = $db->createCommand($sql)->queryRow();
	 	
				$sql = 'SELECT *  FROM categories WHERE  uri = "'.$uri.'" GROUP by id';//  visibly = 1 AND
	 			$C = $db->createCommand($sql)->queryRow();
	 			$label = $C['name'];
	 			if ($label == '')
	 				throw new CHttpException(404,'Ой, такой страницы нет');
	 			
				if (isset($C['meta_title']) && $C['meta_title'] != ''){
					$this->pageTitle=$C['meta_title'].'';
					Yii::app()->clientScript->registerMetaTag($C['meta_description'], 'description');
					Yii::app()->clientScript->registerMetaTag($C['meta_keywords'], 'keywords');
				} else 
					$this->pageTitle=$label.'';
				
			}else {
				$label = 'Каталог';
				$this->pageTitle=$label.'';
				$category = array('feature_variants' => '');
				$C = array('label_description' => '', 'description' => '');
			}
			
			$p = new CHtmlPurifier;
			
			$GetPice = '';
			$GetType = '';
			$GetSort  = '';
					
			if (isset($_GET['price']) && is_numeric(str_replace(' ', '', $_GET['price']))){
				$GetPice = (int)str_replace(' ', '', $_GET['price']);
			}
			if (isset($_GET['type']) && $p->purify($_GET['type']) != '' &&  $p->purify($_GET['type']) != 'Все'){
				$GetType = $p->purify($_GET['type']);
			}
			
			if (isset($_GET['sort']) && ( $p->purify($_GET['sort']) != 'asc' || $p->purify($_GET['sort']) != 'desc')){
				$GetSort  = $p->purify($_GET['sort']);
			}
		
			$sql = 'SELECT p.id FROM products p INNER JOIN  products_category pc ON pc.product_id = p.id INNER JOIN categories c ON c.id = pc.category_id WHERE   p.visibly = 1 '.(($uri != '')? 'AND c.uri = "'.$uri.'"' : '').(($GetPice != '')? 'AND p.price <= '.$GetPice : '').' AND p.img != "" AND p.img != "|" GROUP by p.id ORDER by '.(($GetSort) ? 'p.price '.$GetSort.'' :'p.orders ASC').'';//' AND c.visibly = 1 '.
			$total = $db->createCommand($sql)->queryAll();			
			
			$pageisze = count($total);
				
			
			$pages = new CPagination(count($total));
			$pages->pageSize = $pageisze;
			$offset = $pages->getOffset();
			$limit = $pages->getLimit();
			
 			$sql = 'SELECT p.*, c.uri as cat_uri, c.id cat_id, c.name cat_name FROM products p INNER JOIN  products_category pc ON pc.product_id = p.id INNER JOIN categories c ON c.id = pc.category_id WHERE   p.visibly = 1 '.(($uri != '')? 'AND c.uri = "'.$uri.'"' : '').(($GetPice != '')? 'AND p.price <= '.$GetPice : '').' AND p.img != "" AND p.img != "|" GROUP by p.id ORDER by '.(($GetSort) ? 'p.price '.$GetSort.'' :'p.orders ASC, p.id DESC').' LIMIT '.$offset.','.$limit.'';
 			$products = $db->createCommand($sql)->queryAll();//' AND c.visibly = 1 '.
 			
 			
			$productId = array();
			$categories = array();
			foreach ($products as $product) {
				$productId[] =  $product['id'];
				if (empty($categories[$product['cat_id']]) && $product['cat_id'] != 73) {
					$categories[$product['cat_id']] = array('id' => $product['cat_id'],'name' => $product['cat_name']);
				}
			}
			ksort($categories);
		
			$ProductsTo = array();
			if (count($productId) > 0) {
				$sql3 = 'SELECT fp.product_id, fp.value as feature_value FROM features_products fp LEFT JOIN {{features}} f ON fp.feature_id = f.id WHERE fp.product_id IN ('.implode(',', $productId).') AND f.name = "'.(($uri == 'rozy') ? 'Ростовка' : 'Состав').'" '.(($GetType != '') ? 'AND LOWER(fp.value) LIKE "%'.$GetType.'%"' : '').' GROUP by fp.product_id ';
				$ProductsTo = $db->createCommand($sql3)->queryAll();
				
			}
			$ProductsToNew = array();
			foreach ($ProductsTo as $product) {
				$ProductsToNew[$product['product_id']] = $product;
				if (!empty($product['feature_value'])) {
					$featureArr = explode('|',$product['feature_value']);
					foreach($featureArr as $f) {
						if (!in_array($f,$features)) {
							$features[] = $f;
						}
					}
				}
			}
			$category['feature_variants'] = implode('|', $features);
			
			$productsTo = array();
			$i = 0;
			$priceRanges = [];
			$priceMax = 0;
			$priceSteps = [1000,3000];
			foreach ($products as $product) {
				
				$productsTo[$i] = $product;
				if (isset($ProductsToNew[$product['id']])){
					$productsTo[$i]['feature_value'] = $ProductsToNew[$product['id']]['feature_value'];
				}
				if (empty($priceRanges[0]) && $product['price'] < $priceSteps[0]) {
					$priceRanges[0] = [
						'prices'=>$priceSteps[0],
						'title' => 'до&nbsp;'.number_format($priceSteps[0], 0, ',', '&nbsp;')
					];
				} elseif (empty($priceRanges[1]) && $product['price'] >= $priceSteps[0] && $product['price'] < $priceSteps[1]) {
					$priceRanges[1] = [
						'prices'=>$priceSteps[0].'-'.$priceSteps[1],
						'title' => number_format($priceSteps[0], 0, ',', '&nbsp;').'&ndash;'.number_format($priceSteps[1], 0, ',', '&nbsp;')
					];
				}
				if ($priceMax < $product['price']) {
					$priceMax = $product['price'];
				}
				$i++;
			}
			if ($priceMax > $priceSteps[1]) {
				$priceRanges[2] = [
					'prices'=>$priceSteps[1].'-'.$priceMax,
					'title' => number_format($priceSteps[1], 0, ',', '&nbsp;').'&ndash;'.number_format($priceMax, 0, ',', '&nbsp;')
				];
				//$priceRanges['3000-6000'] = number_format($priceSteps[1], 0, ',', '&nbsp;').'&ndash;'.number_format($priceMax, 0, ',', '&nbsp;');
			}
			if (count($priceRanges) > 1) {
				ksort($priceRanges);
			}
			$products = $productsTo;
			
 			if(Yii::app()->request->isPostRequest)
 				$this->renderPartial('items_line', array(
 						'products' => $products,
 						'pages'=>$pages,
 						
 				));
 			else {
				$this->render('index', array(
						'products' => $products,
						'pages'=>$pages,
						'total' => count($total),
						'category'=> $category,
						'categories'=> $categories,
						'label' => $label,
						'C' => $C,
						'priceRanges' => $priceRanges
				));
 			}
		
		} else {
			/* get all Products in categody */
			$sql = 'SELECT p.*, c.uri as cat_uri, op.others FROM products p INNER JOIN  products_category pc ON pc.product_id = p.id INNER JOIN categories c ON c.id = pc.category_id  LEFT JOIN  others_products op ON op.prod_id = p.id WHERE p.visibly = 1 '.(($uri != '')? 'AND c.uri = "'.$uri.'"' : '').' AND p.img != "" AND p.img != "|"  GROUP by p.id ORDER by p.orders ASC, p.id DESC';// AND c.visibly = 1
			$productsAll = $db->createCommand($sql)->queryAll();
			
			
			$sql = 'SELECT count FROM categories  WHERE uri = "'.$uri.'"';
			$CheckCount = $db->createCommand($sql)->queryScalar();
			
			
			/* get select product & prev and next */
			$prev = '';
			$next = '';
			$productsAllIds = array();
			foreach($productsAll as $k => $p){
				
				if ($p['id']== $id){
					$product = $p;
					if (isset($productsAll[$k - 1]))
						$prev = $productsAll[$k - 1];
					if (isset($productsAll[$k + 1]))
						$next = $productsAll[$k + 1];
					unset($productsAll[$k]);
				}
				$productsAllIds[] = $p['id'];
			}
			
			if (!isset($product['id']))
			throw new CHttpException(404,'Ой, такого товара нет');
			
			if (isset($product['meta_title']) && $product['meta_title'] != ''){
				$this->pageTitle=$product['meta_title'].'';
				Yii::app()->clientScript->registerMetaTag($product['meta_description'], 'description');
				Yii::app()->clientScript->registerMetaTag($product['meta_keywords'], 'keywords');
			} else
				$this->pageTitle= $product['name'].'';
			
			
			$sql = 'SELECT fpp.id, fpp.value, fpp.price FROM feature_product_price fpp LEFT JOIN features f ON f.id = fpp.feature_id WHERE f.visibly = 1 AND (f.price = "1" OR f.price = 1) AND fpp.product_id = '.$id.'';
			$product['features_price'] = $db->createCommand($sql)->queryAll();
			$product['features_price_name'] = '';
			
			/* get all features in all products in category */
			
			if (count($productsAllIds) > 0){
				$sql = 'SELECT f.*,  fp.value, fp.product_id  FROM features f LEFT JOIN features_products fp ON f.id = fp.feature_id WHERE f.visibly = 1 AND fp.visibly = 1 AND fp.product_id IN ('.implode(',',$productsAllIds).') ORDER by f.type';
				$featuresAll = $db->createCommand($sql)->queryAll();
			} else 
				$featuresAll = array();
			
			
			/* merge features with here products */
			$Fetures_product = array();
			foreach($featuresAll as $f) {
				if($f['price'] == 1)
					$product['features_price_name'] = $f['name'];
				
				$Fetures_product[$f['product_id']][$f['id']] = $f;
			}
			
			foreach($productsAll as $k => $p){
				if(isset($Fetures_product[$p['id']]))
					$productsAll[$k]['features'] = $Fetures_product[$p['id']];
			}
			if(isset($Fetures_product[$product['id']]))
				$product['features'] = $Fetures_product[$product['id']];
			else 	
				$product['features'] = array();
			
			/* sort all products width select product features */
			foreach($product['features'] as $f){
				$name = strtolower($f['name']);
				if ( $name == 'состав' || $name == 'pостовка' || $name == 'Состав' || $name == 'Ростовка') {
					$sort_feature = $f;
					$Subject_arr = explode('|', $f['value']);
					$Subject_arr = array_diff($Subject_arr, array(''));
					$sort_feature['patterns'] = $Subject_arr;
					if ($name == 'состав' || $name == 'Состав'){
						break;
					}
				}
			}
		
			/* sort to features */
			$SortProduct = array();
			//if (isset($sort_feature)){
				
				foreach($productsAll as $k => $p){
					if (isset($sort_feature['id']) && isset($p['features'][$sort_feature['id']])){
						$subject = $p['features'][$sort_feature['id']]['value'];
						$m = 0;
						foreach($sort_feature['patterns'] as $parent){
							preg_match('/'.$parent.'/is', $subject, $matches);
							$m += count($matches);
						}
						
						$SortProduct[$m.$p['id']] = $p;
					}else 
						$SortProduct['0'.$p['id']] = $p;
				}
			//}
			krsort($SortProduct);
			
			
			/* sort to prices */
			//$price_start = (int)$product['price'] - (int)$product['price']*0.3;
			//$price_end = (int)$product['price'] + (int)$product['price']*0.3;
			$price_start = (int)$product['price'] - 500;
			$price_end = (int)$product['price'] + 500;
			foreach ($SortProduct as $k => $p ){
				if ((int)$p['price'] > $price_start && (int)$p['price'] < $price_end){
				
				}else 
					unset($SortProduct[$k]);
			}
			
			$pages = new CPagination(count($SortProduct));
			$pages->pageSize = 16;
			
			
			/* OTHERS PRODUCTS */
			$others = explode('|',$product['others']);
			$IdsOthers = array();
			foreach($others as $oth) {
				if ($oth != ''){
					$ar = explode(':', $oth);
					$IdsOthers[] = $ar[0];
				}
			}
			if (count($IdsOthers) > 0){
				$sql = 'SELECT p.*, c.uri as cat_uri FROM products p INNER JOIN  products_category pc ON pc.product_id = p.id INNER JOIN categories c ON c.id = pc.category_id WHERE  p.visibly = 1 AND p.id IN ('.implode(', ',$IdsOthers).')  GROUP by p.id ';//  c.visibly = 1 AND
				$product['others'] = $db->createCommand($sql)->queryAll();
			} else
				$product['others'] = array();
			
				
			if(Yii::app()->request->isPostRequest){
				$this->renderPartial('view', array(
						'product' => $product,
						'prev' => $prev,
						'next' => $next,
						'products' => $SortProduct,
						'pages' => $pages,
						'CheckCount' => $CheckCount,
				));
			}else {
				$this->render('view', array(
						'product' => $product,
						'prev' => $prev,
						'next' => $next,
						'products' => $SortProduct,
						'pages' => $pages,
						'CheckCount' => $CheckCount,
				));
			}
			
		}
	}
	
	
	public function actionAdd($id)
	{	
		$db = Yii::app()->db;
		$sql = 'SELECT p.id, p.name, p.price, p.img, c.uri as cat_uri FROM {{products}} p
				INNER JOIN {{products_category}} pc ON pc.product_id = p.id
				INNER JOIN {{categories}} c ON pc.category_id = c.id			
 				WHERE p.id = '.$id.' AND p.visibly = 1';
			
		$product = $db->createCommand($sql)->queryRow();
		
		
		$fid = 0;
		if(isset($_GET['fid'])){
			if (!is_numeric($_GET['fid']))
				throw new CHttpException(401,'Ошибка добавления в корзину. Такого товара не существует');
			

			$sql = 'SELECT price FROM feature_product_price WHERE id = '.$_GET['fid'].' AND product_id = '.$id.'';
			$FPrice = $db->createCommand($sql)->queryScalar();
			
			if (!is_numeric($FPrice))
				throw new CHttpException(401,'Ошибка добавления в корзину. Такого товара не существует');
			
			$fid = $_GET['fid'];
		} else
			$FPrice = $product['price'];
		
		if (!isset($product['id']))
				throw new CHttpException(401,'Ошибка добавления в корзину. Такого товара не существует');
			
		$count = 1;
		if(isset($_POST['count']) && is_numeric($_POST['count'])){
			$count = $_POST['count'];
			if ((int)$count > 999)
				$count = 999;
		}
		
		
		$cart =  (string)Yii::app()->request->cookies['cart'];
		
		$i = 0;	
		$ARR_products = explode('|', $cart);
		
		$checkProduct = false;
		foreach ($ARR_products as $K => $V){
			$ARRone = explode(':', $V);
			if ((int)$ARRone[0] == (int)$product['id'] && (int)$FPrice == (int)$ARRone[1] &&  (int)$fid == (int)$ARRone[3]) {
				$ARRone[2] = (int)$ARRone[2] + $count;
				$count = $ARRone[2];
				$ARR_products[$K] = implode(':', $ARRone);
				$checkProduct = true;
				
			}
		}
		if (!$checkProduct){
			$ARR_products[] = $product['id'].':'.$FPrice.':'.$count.':'.$fid;
		}

		$ARR_products = array_diff($ARR_products, array(''));
		Yii::app()->request->cookies['cart'] = new CHttpCookie('cart', implode('|', $ARR_products));
		if(Yii::app()->request->isPostRequest){
			$Arrimg = explode('|', $product['img']);
			$Arrimg = array_diff($Arrimg, array(''));
			$link = '/catalog/'.$product['cat_uri'].'/'.$product['id'];
			$price = number_format( $FPrice, 0, ',', ' ' );
			
			echo CJSON::encode(array(
				'error' => 0,
				'id'=> $product['id'].$fid,
				'preview' => 
						'
							<img src="/uploads/81x84/'.current($Arrimg).'" width="50">
							<div class="preview_item_name"><a href="'.$link.'" class="blue ">'.trim(str_replace(' ', '&nbsp;', $product['name'])).'</a></div>
							<div class="preview_item_name_overlay"></div>
							<div class="preview_item_price item_price">'.$price.' <span class="b-rub">Р</span>, '.$count.' шт</div>
							<a href="/catalog/delete/'.$product['id'].'" title="удалить из корзины" class="non basket_item_del">×</a>
						',
			));
		}else {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
	}
	
	public function actionDelete($id)
	{
		$cart =  (string)Yii::app()->request->cookies['cart'];
		
		$i = 0;
		$check = false;
		$ARR_products = explode('|', $cart);
		
		$ARR_products = array_diff($ARR_products, array(''));
		
		foreach($ARR_products as $K => $V){
			$Arrone = explode(':', $V);
			if ($Arrone[0] == $id && !$check){
				unset($ARR_products[$K]);
				$check = true;
			}
				
		}
		Yii::app()->request->cookies['cart'] = new CHttpCookie('cart', implode('|', $ARR_products));
		if(Yii::app()->request->isPostRequest){
			
			echo CJSON::encode(array(
					'error' => 0,
					
			));
		}else {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
	}
	
	public function actionDelall()
	{
		Yii::app()->request->cookies['cart'] = new CHttpCookie('cart', '');
		
		if(Yii::app()->request->isPostRequest){
			echo CJSON::encode(array(
					'error' => 0,
			));
		}else {
			$this->redirect(Yii::app()->request->urlReferrer);
		}
	}
	
	public function actionSort()
	{
	
		if(Yii::app()->request->isPostRequest){
			Formats::setCoockieSort($_POST);
			
		}else {
			throw new CHttpException(404,'Ой, такой страницы нет');
		}
	}
	

	
	
	
}

