<?php


use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="w-75 mx-auto">
<div class="current-info">

<h6>Current Setting</h6>
<ul>
    <li>
Shift / <?= $items['shift'] ?>
</li>
<li>
Cashier / <?= $items['cashier'] ?>
</li>
</ul>
</div>


<?=  HTML::beginForm(Url::toRoute('info/index')) ?>


<h6>Shift</h6><?= HTML::DropDownList('shift','Morning',['Morning'=>'Morning ','Evening'=>'Evening '],['class'=>'form-control']) ?>
<h6>Cashier</h6><?= HTML::TextInput('cashier','',['class'=>'form-control'])?>
<br>
<?= HTML::submitButton('Save',['class'=>'btn btn-info'])?>

<?= HTML::endForm() ?>

</div>