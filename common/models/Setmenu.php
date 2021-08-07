<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "setmenu".
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string $description
 * @property string|null $image
 */
class Setmenu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setmenu';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'description'], 'required'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 32],
            [['image'], 'string', 'max' => 256],
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
            'description' => 'Description',
            'image' => 'Image',
        ];
    }



    
    public function getProducts()
    {
        return $this->hasMany(Product::class,['id'=>'product_id'])
        ->viaTable('productset',['set_id'=>'id']);
    }
}
