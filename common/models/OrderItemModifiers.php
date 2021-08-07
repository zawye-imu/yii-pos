<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_item_modifiers".
 *
 * @property int $id
 * @property int|null $orderitem_id
 * @property int|null $modifier_id
 * @property int|null $qty
 *
 * @property Modifiers $modifier
 * @property Orderitem $orderitem
 */
class OrderItemModifiers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_item_modifiers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['orderitem_id', 'modifier_id', 'qty'], 'integer','min'=>1],
            [['modifier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Modifiers::className(), 'targetAttribute' => ['modifier_id' => 'id']],
            [['orderitem_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orderitem::className(), 'targetAttribute' => ['orderitem_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'orderitem_id' => 'Orderitem ID',
            'modifier_id' => 'Modifier ID',
            'qty' => 'Qty',
        ];
    }

    /**
     * Gets query for [[Modifier]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModifier()
    {
        return $this->hasOne(Modifiers::className(), ['id' => 'modifier_id']);
    }

    /**
     * Gets query for [[Orderitem]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderitem()
    {
        return $this->hasOne(Orderitem::className(), ['id' => 'orderitem_id']);
    }
}
