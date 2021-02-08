<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property integer $id
 * @property string $status
 * @property string $date
 * @property string $time
 * @property string $to_name
 * @property string $address
 * @property integer $to_phone
 * @property string $from_email
 * @property string $products_id
 * @property integer $price
 * @property string $comment
 * @property string $mod_datetime
 * @property integer $discount
 * @property integer $discount_price
 * @property string $admin_comment
 * @property string $zip_code
 * @property string $city
 * @property string $delivery
 * @property string $payment
 * @property string $paid
 * @property string $transaction_id
 * @property string $from_name
 * @property integer $from_phone
 * @property string $to_notice
 * @property string $from_notice
 * @property string $picture
 */
class Order extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Order the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('', 'required'),
			array('price, discount, discount_price', 'numerical', 'integerOnly'=>true),
			array('status', 'length', 'max'=>9),
			array('to_phone, from_phone', 'length', 'max'=>18, 'min'=>18),
			array('date, time, from_email, mod_datetime, zip_code, city, delivery, transaction_id', 'length', 'max'=>255),
			array('payment, paid, to_notice,,to_from, picture', 'length', 'max'=>1),
			array('from_notice', 'length', 'max'=>4),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, status, date, time, to_name, address, to_phone, from_email, products_id, price, comment, mod_datetime, discount, discount_price, admin_comment, zip_code, city, delivery, payment, paid, transaction_id, from_name, from_phone, to_notice, from_notice, picture', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'status' => 'Status',
			'date' => 'Date',
			'time' => 'Time',
			'to_name' => 'To Name',
			'address' => 'address',
			'to_phone' => 'To Phone',
			'from_email' => 'From Email',
			'products_id' => 'Products',
			'price' => 'Price',
			'comment' => 'Comment',
			'mod_datetime' => 'Mod Datetime',
			'discount' => 'Discount',
			'discount_price' => 'Discount Price',
			'admin_comment' => 'Admin Comment',
			'zip_code' => 'Zip Code',
			'city' => 'City',
			'delivery' => 'Delivery',
			'payment' => 'Payment',
			'paid' => 'Paid',
			'transaction_id' => 'Transaction',
			'from_name' => 'From Name',
			'from_phone' => 'From Phone',
			'to_notice' => 'To Notice',
			'from_notice' => 'From Notice',
			'picture' => 'Picture',
			'to_from' => 'To From',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('to_name',$this->to_name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('to_phone',$this->to_phone);
		$criteria->compare('from_email',$this->from_email,true);
		$criteria->compare('products_id',$this->products_id,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('mod_datetime',$this->mod_datetime,true);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('discount_price',$this->discount_price);
		$criteria->compare('admin_comment',$this->admin_comment,true);
		$criteria->compare('zip_code',$this->zip_code,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('delivery',$this->delivery,true);
		$criteria->compare('payment',$this->payment,true);
		$criteria->compare('paid',$this->paid,true);
		$criteria->compare('transaction_id',$this->transaction_id,true);
		$criteria->compare('from_name',$this->from_name,true);
		$criteria->compare('from_phone',$this->from_phone);
		$criteria->compare('to_notice',$this->to_notice,true);
		$criteria->compare('from_notice',$this->from_notice,true);
		$criteria->compare('picture',$this->picture,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}