<?php

/**
 * This is the model class for table "products".
 *
 * The followings are the available columns in table 'products':
 * @property integer $id
 * @property string $name
 * @property integer $price
 * @property integer $cat_id
 * @property string $img
 * @property integer $rating
 * @property integer $orders
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $visibly
 * @property integer $features_id
 */
class Product extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Product the static model class
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
		return 'products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, price, cat_id, img, rating, orders, meta_title, meta_keywords, meta_description, visibly, features_id', 'required'),
			array('price, cat_id, rating, orders, features_id', 'numerical', 'integerOnly'=>true),
			array('name, meta_title, meta_keywords', 'length', 'max'=>255),
			array('visibly', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, price, cat_id, img, rating, orders, meta_title, meta_keywords, meta_description, visibly, features_id', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'price' => 'Price',
			'cat_id' => 'Cat',
			'img' => 'Img',
			'rating' => 'Rating',
			'orders' => 'Orders',
			'meta_title' => 'Meta Title',
			'meta_keywords' => 'Meta Keywords',
			'meta_description' => 'Meta Description',
			'visibly' => 'Visibly',
			'features_id' => 'Features',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('img',$this->img,true);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('orders',$this->orders);
		$criteria->compare('meta_title',$this->meta_title,true);
		$criteria->compare('meta_keywords',$this->meta_keywords,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('visibly',$this->visibly,true);
		$criteria->compare('features_id',$this->features_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}