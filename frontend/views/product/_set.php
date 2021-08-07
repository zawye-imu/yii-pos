
<?php
 use yii\helpers\Html;
 use yii\helpers\Url;



?>

<div class="whole-card">   
    
<?php echo HTML::img("@web/setImages/".$model->image,[
        'style' => 'max-width:10vw;height:10vw;padding-left:3vw;'
    ]);
?>
<div class="card border-info mb-3" style="max-width: 15vw;height:20vw">
  <div class="card-header"><?= $model->name ?></div>
  <div class="card-body text-info">
    <h5 class="card-title"><?= Yii::$app->formatter->asCurrency($model->price);  ?></h5>
    <p class="card-text"><?= $model->description ?></p>



    <?= HTML::input('hidden','sid',$model->id,['class'=>'sid']) ?>
    <?= HTML::input('number','set_qty',1,['class'=>'form-control s_qty',
    'min'=>'1','oninput'=>'validity.valid||(value="");']) ?>
    <br>
    <?= HTML::button('Add to cart',["class" => "btn btn-info set-confirm" ]); ?>
  </div>
</div>

</div>  