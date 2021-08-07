<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orderitem".
 *
 * @property int $id
 * @property int|null $product_id
 * @property int|null $set_id
 * @property int $order_id
 * @property int|null $qty
 *
 * @property Order $order
 * @property Product $product
 * @property Setmenu $set
 */
class Orderitem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orderitem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'set_id', 'order_id', 'qty'], 'integer','min'=>1],
            [['order_id'], 'required'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::className(), 'targetAttribute' => ['order_id' => 'id']],
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
            'order_id' => 'Order ID',
            'qty' => 'Qty',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Set]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSet()
    {
        return $this->hasOne(Setmenu::className(), ['id' => 'set_id']);
    }
}
