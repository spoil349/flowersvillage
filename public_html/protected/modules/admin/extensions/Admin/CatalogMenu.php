<?php
class CatalogMenu extends CWidget
{

	public $Catalog = array();
	public $select_cat = '';

	public function init()
	{
		$menu = '';
		$select= false;
		$one_section = '';
		$line_category = '<li><a '.(($this->select_cat == '' ) ? 'class="select"' : '').' href="/admin/products/list/">Все</a></li>';
		foreach ($this->Catalog as $section){
			
			foreach ($section['category'] as $category){
				$line_category .= '<li><a '.(($this->select_cat == $category['id']) ? 'class="select"' : '').' href="/admin/products/list/'.$category['id'].'">'.$category['name'].'</a></li>';
			}
		}
		echo '
				<div class="catalog_product_right">
					<h4>Категории</h4>
					<ul>'.$line_category.'</ul>
				</div>
				';
	}

}