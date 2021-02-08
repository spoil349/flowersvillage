<?php

class CatalogMenu extends CWidget
{
	public $cat = false;
	
	
	public function init()
	{
		$db = Yii::app()->db;
		$sql = 'SELECT c.id, c.name, c.uri FROM {{categories}} c WHERE c.visibly = 1 AND c.hidden = 0 Group by c.id ORDER BY c.orders';
		$categories = $db->createCommand($sql)->queryAll();
		
		$sql = 'SELECT * FROM {{pages}} c WHERE menu_sort > 0 ORDER BY menu_sort';
		$pages = $db->createCommand($sql)->queryAll();
		/*
		$this->widget('widget.CatalogMenu',array(
			'cat' => Yii::app()->request->url,		
		));
		*/
		
		
		$this->render('catalog_menu', array(
				'Catalog' => $categories,
				'cat' => $this->cat,
				'pages' => $pages,
		));
	}
	
	
}
