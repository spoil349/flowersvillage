<?php

class OrdersController extends Controller
{
	public $layout ='application.modules.admin.views.layouts.main';
	public $layoutPath ="protected/modules/admin/views/layouts";
	
	public function actionIndex() {
		$this->redirect('/admin/orders/list/',array());
	}	
	
	public function actionList($cat_uri = '') {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
		
		if ($cat_uri == ''){
			//$this->redirect('/admin/orders/list/new',array());
		}
		
		$this->render('list',array(
				'ARRitems' => $this->module->GetAllOrdersToStatus($cat_uri),
				'ARRstatus' => $this->module->GetAllOrdersStatus(),
				
			)
		);
	}
	
	public function actionEdit($id) {
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
				
			$ARRorder= $this->module->GetOrderWithAll($id);
		
			$this->render('edit',array(
					'ARRorder' => $ARRorder,
					'ARRstatus' => $this->module->GetAllOrdersStatus(),
					'ARRdelivery' => $this->module->GetAllOrdersDelivery(),
					'ARRpayment' => $this->module->GetAllOrdersPayment(),
					'ARRpaid' => $this->module->GetAllOrdersPaid(),
				)
			);
	}
	
	public function actionImport() {
		//public $convertActiveDataProvider = true;
		if (!Yii::app()->user->getState('auth')) $this->redirect('/',array());
				
		$ARRorder= $this->module->GetAllOrdersToStatus();
		$this->layout = false;
		$cleanList = array();
		$i = 1;
		foreach($ARRorder as $k => $order) {
			$cleanList[] = array(
				'id'=>'"'.$order['id'].'"',
				'Дата'=>'"'.date('d.m.Y H:i', $order['create_time']/*strtotime($order['date'].' '.$order['date'])*/).'"',
				'Имя'=>'"'.$order['to_name'].'"',
				'Тел'=>'"'.$order['to_phone'].'"',
				'Сумма'=>'"'.$order['price'].'"',
				'Примечание'=>'"'.$order['comment'].'"',
				'address'=>'"'.$order['address'].'"',
			);
		}
		//$out = fopen('php://output', 'w');
		$fiveMBs = 5 * 1024 * 1024; 
		//$out = fopen("php://temp/maxmemory:$fiveMBs", 'w');
		$lines = array();
		foreach ($cleanList as $order) {
			//fputcsv($out, $order, ';');
			$lines[] = implode(';',$order);
		}
		$text=implode(PHP_EOL,$lines);
		$filename='orders.csv';

		header('Content-Type: text/csv;charset=utf-8');
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Disposition: attachment; filename=$filename");
		header("Content-Transfer-Encoding: binary");  
		echo "\xEF\xBB\xBF"; // Byte Order Mark
		echo $text;

		Yii::app()->end();
		exit;

	}
}
