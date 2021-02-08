<?php

class Basket extends CWidget
{
	public $aloading = true;
	
	public function init()
	{
		$cart =  (string)Yii::app()->request->cookies['cart'];
		$ARR_products = explode('|', $cart);
		$SelectArr = array();
		foreach ($ARR_products as $K => $V) {
			if ($V != ''){
				$Arrone = explode(':', $V);
				$SelectArr[] = $Arrone[0];
			}
		}
		$products = array();
		$IDproduct = array();
		if (count($SelectArr) > 0) {
			$db = Yii::app()->db;
			$sql = 'SELECT p.id, p.name, p.price, p.img, c.uri as cat_uri FROM {{products}} p
				INNER JOIN {{products_category}} pc ON pc.product_id = p.id
				INNER JOIN {{categories}} c ON pc.category_id = c.id
 				WHERE p.id IN ('.implode(',', $SelectArr).') AND p.visibly = 1';				
			$ProductsArr = $db->createCommand($sql)->queryAll();
			
			
			foreach($ProductsArr as $pr)
				$IDproduct[$pr['id']] = $pr;
			
		}
		$i = 0;
		foreach($ARR_products  as $K => $V){
		if ($V != ''){
				$Arrone = explode(':', $V);
				$products[$i] = $IDproduct[$Arrone[0]];
				$products[$i]['price'] = $Arrone[1];
				$products[$i]['count'] = $Arrone[2];
				$products[$i]['fid'] = $Arrone[3];
				$i++;
			}
		}
		
		$this->render('basket', array(
				'products' => $products,
				'aloading' => $this->aloading,
		));
		
		
	}
	
	
}
