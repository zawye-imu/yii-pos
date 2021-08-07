<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property string|null $payment
 * @property string|null $shift
 * @property string|null $dine
 * @property string|null $cashier
 * @property float|null $discount
 * @property float|null $subtotal
 * @property float|null $grandtotal
 * @property int|null $status
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['discount'], 'number'],
            [['subtotal', 'grandtotal'],'number','min'=>1],
            [['status', 'created_at','updated_at'], 'integer'],
            [['payment', 'shift', 'dine', 'cashier'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'payment' => 'Payment',
            'shift' => 'Shift',
            'dine' => 'Dine',
            'cashier' => 'Cashier',
            'discount' => 'Discount',
            'subtotal' => 'Subtotal',
            'grandtotal' => 'Grandtotal',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


}
