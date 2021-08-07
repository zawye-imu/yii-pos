<?php

use common\models\Modifiers;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

$dataProvider = new ActiveDataProvider([
    'query' => Modifiers::find(),
]);

?>
<div class="whole-card">   
    
<?php echo HTML::img("@web/productImages/".$model->image,[
        'style' => 'width:10rem;height:6rem;padding-left:3vw;'
    ]);
?>
<div class="card border-info mb-3" style="max-width:15rem;height:15rem;">
  <div class="card-header"><?= $model->name ?></div>
  <div class="card-body text-info">
    <h5 class="card-title"><?= Yii::$app->formatter->asCurrency($model->price);  ?></h5>
    <p class="card-text"><?= $model->description ?></p>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="<?= '#modal'.$model->id ?>">
    Add to cart
    </button>

  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="<?= 'modal'.$model->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Choose modifiers</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <?= $model->name ?> : Qty <input type="number" name='product_qty' id='product_qty' value='1' min='1' oninput='validity.valid||(value="");'>
            <?= ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => '_modifier',
                'summary' => false,
                'itemOptions' => [
                    'class' => 'modifier_card',
                ]
                
            ]); ?>

      </div>
      <div class="modal-footer">
        <input type="hidden" value="<?= $model->id ?>" id="product_id">
        <button type="button" class="btn btn-info modal-confirm">Confirm</button>
      </div>
    </div>
  </div>
</div>







</div>