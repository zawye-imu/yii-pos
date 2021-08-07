<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "productset".
 *
 * @property int $id
 * @property int $product_id
 * @property int $set_id
 * @property int|null $qty
 *
 * @property Product $product
 * @property Setmenu $set
 */
class Productset extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productset';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'set_id'], 'required'],
            [['product_id', 'set_id', 'qty'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
            [['set_id'], 'exist', 'skipOnError' => true, 'targetClass' => Setmenu::className(), 'targetAttribute' => ['set_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'set_id' => 'Set ID',
            'qty' => 'Qty',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery|ProductQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Set]].
     *
     * @return \yii\db\ActiveQuery|SetmenuQuery
     */
    public function getSet()
    {
        return $this->hasOne(Setmenu::className(), ['id' => 'set_id']);
    }


}
