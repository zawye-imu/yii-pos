<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Url;

$session = Yii::$app->session;

// Getting subtotal data from another controller method.
$cat=Yii::$app->createController('checkout/subtotal');
$cat=$cat[0]; 
$subtotal=$cat->actionSubtotal();

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shop';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <br>

    <div class='row'>
    <div class="col-8 cards">
  

    <!-- Tab Section -->
    <ul class="nav nav-tabs">
    <li class="nav-item">   
        <a class="nav-link nav-shop" href="<?= Url::toRoute('product/shop')?>">Products</a>
    </li>
    <li class="nav-item">
        <a class="nav-link nav-set" href="<?= Url::toRoute('product/set') ?>">Sets</a>
    </li>

    </ul>


    <div class='shop-items'>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => $view,
        'summary' => false,
        'emptyText' => false,
        
    ]); ?>
    </div>


    </div>


    <!-- Cart Section Show -->

    <div class="col-4">
        <h4></h4>


        <?= $this->render('_cart',['item'=>$session['cart'],'subtotal'=>$subtotal]) ?>




    </div>

    </div>
</div>
