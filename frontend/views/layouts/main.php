<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-light bg-light',
        ],
    ]);

    // Handling different menu items. 
    if(!empty(Yii::$app->request->queryParams))
    {
        if(Yii::$app->request->queryParams['r']=='checkout/index')
        {
        $menuItems = [];
        }   
        else
        {
            $menuItems = [
    
                ['label' => 'Shop', 'url' => ['/product/shop']],
                ['label' => 'Info', 'url' => ['/info/index']],
        
            ];
        }
    }
    else
    {
        $menuItems = [

            ['label' => 'Shop', 'url' => ['/product/shop']],
            ['label' => 'Info', 'url' => ['/info/index']],
    
        ];
    }


    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
    <div class="content"> 
    

        <?= Alert::widget() ?>
          
        <?= $content ?>
    

    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
