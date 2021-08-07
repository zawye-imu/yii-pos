<?php
use yii\helpers\Html;
?>

<div class="card mt-3" style="width:12rem;margin-left:10px;">
  
  <?= HTML::img("@web/modifierImages/".$model->image,[
        'style' => 'max-width:10vw;height:7vw;margin:auto;'
    ]);
?>
  <div class="card-body">
    <h5 class="card-title"><?= $model->name; ?></h5>
    <p><?= Yii::$app->formatter->asCurrency($model->price); ?></p>
    <span class="m_qty">0</span>
    <a href="#" class="btn btn-info m_add">Add</a>
    <a href="#" class="btn btn-danger m_minus">Minus</a>
  </div>

  
</div>