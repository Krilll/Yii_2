<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $price
 * @property int $created_at
 */
class Product extends \yii\db\ActiveRecord
{
	const SCENARIO_CREATE = 'create';
	const SCENARIO_UPDATE = 'update';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }
	
	public function scenarios()
	{
		return [
			self::SCENARIO_DEFAULT => ['name'],
			self::SCENARIO_UPDATE => ['price'],
			self::SCENARIO_CREATE => ['name', 'price', 'created_at'],
		];
	}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'created_at'], 'required'],
            [['created_at'], 'integer'],
			[['name'], 'string', 'max' => 20],
			[['name'], 'trim'],
			[['name'], 'filter', 'filter' => 'strip_tags'],
            [['price'], 'integer', 'min' => 0, 'max' => 1000],
        ];
    }
	

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'created_at' => 'Created At',
        ];
    }
}
