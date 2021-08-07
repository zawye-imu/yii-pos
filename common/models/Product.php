<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string|null $description
 * @property string|null $image
 */
class Product extends \yii\db\ActiveRecord
{

    public $image_tmp;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 64],
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


    /**
     * Overiding the save method of BaseActiveRecord to save an image. 
     * @return boolean
     */
    public function save($runValidation = true, $attributeNames = null)
    {
         $isInsert = $this->isNewRecord;
         if($isInsert)
         {
            $this->image = Yii::$app->security->generateRandomString(5).'__'.$this->image_tmp->name;
         }
    
        $saved= parent::save($runValidation,$attributeNames);
        if (!$saved)
        {
            return false;
        }
        if($isInsert)
        {
            $imagePath = Yii::getAlias('@frontend/productImages/'.$this->image);
           
            if(!is_dir(dirname($imagePath)))
            {
                    FileHelper::createDirectory(dirname($imagePath));
            }
            $this->image_tmp->saveAs($imagePath);
        }
        return true;
    }
}
