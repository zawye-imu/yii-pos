<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

?>
<?php Pjax::begin() ?>
<div id="cart_section"> 
<div>
<h3><i class="bi bi-bag"></i></h3>

</div>

<table class="w-100">

  
<?php
    foreach($item as $key=>$i)
    {   
        
        try{
            echo "<tr>";
            echo  "<td class='font-italic'>".$i['set_qty']."x</td>";
            echo  "<td>".$i['set_name']."</td>";
            echo "<td>".Yii::$app->formatter->asCurrency($i['set_price'])."</td>";
            echo "<td class='text-right'>...".Yii::$app->formatter->asCurrency($i['set_qty']*$i['set_price'])."</td>";
            echo "<td>".
            HTML::a('<i class="bi bi-trash-fill"></i>',
            Url::toRoute(['product/remove','data'=>$key]),[
                'class'=>'ml-3',
                'style' => 'color:black;',
            ])
            ."</td>";
            echo "</tr>";

            // What is included in the set. 
            
            foreach($i['include'] as $key=>$t)
            {
                
                echo "<tr class='sub-text'>";
                echo  "<td class='font-italic'><b>".$t['item_qty']."/set</b></td>";
                echo  "<td><b>".$t['item_name']."</b></td>";
                echo "</tr>";
            }
            
        }
        catch(Exception $e)
        {
            echo "<tr>";
            echo "<td class='font-italic'>".$i['product_qty']."x</td>";
            echo "<td>".$i['product_name']."</td>";
            echo "<td>".Yii::$app->formatter->asCurrency($i['product_price'])."</td>";
            echo "<td class='text-right'>...".Yii::$app->formatter->asCurrency($i['product_qty']*$i['product_price'])."</td>";
            echo "<td>".
            HTML::a('<i class="bi bi-trash-fill"></i>',
            Url::toRoute(['product/remove','data'=>$key]),[
                'class'=>'ml-3',
                'style' => 'color:black;',
            ])
            ."</td>";
            echo "</tr>";

            foreach($i['modifiers'] as $mkey=>$m)
            {
                
                echo "<tr class='sub-text'>";
               
                echo  "<td class='font-italic'><b>".$m['modifier_qty']."x</b></td>";
                echo  "<td><b>".$m['modifier_name']."</b></td>";
                echo "<td><b>".Yii::$app->formatter->asCurrency($m['modifier_price'])."</b></td>";
                echo "<td class='text-right'><b>...".Yii::$app->formatter->asCurrency($m['modifier_qty']*$m['modifier_price'])."</b></td>";
                
                echo "<td>".
                HTML::a('<i class="bi bi-trash-fill"></i>',
                Url::toRoute(['product/remove','data'=>".".$key.".".$mkey]),[
                    'class'=>'ml-3',
                    'style' => 'color:black;font-size:initial;',
                ])
                ."</td>";
                
                echo "</tr>";
            }
        }
        
        
        
    }
?>

</table>
<br>
<p class="font-weight-bold">Sub Total <?= Yii::$app->formatter->asCurrency($subtotal) ?></p>

<?= HTML::beginForm(Url::toRoute('checkout/index')) ?>
<h6>Discount</h6>
<?= HTML::input('number','discount',0,['class'=>'form-control w-50'])?>
<h6>Payment</h6><?= HTML::DropDownList('payment','Cash',
['Cash'=>'Cash ','Credit'=>'Credit '],['class'=>'form-control w-50']) ?>
<h6>Order Type</h6><?= HTML::DropDownList('type','Take-out',
['Take-out'=>'Take-out ','Dine-in'=>'Dine-in '],['class'=>'form-control w-50']) ?>
<br><br>
<?= HTML::submitButton('Confirm',['class'=>'btn btn-info',
'data-confirm'=>'Are you sure with these purchases?']) ?>

<?= HTML::endForm() ?>

</div>

<?php Pjax::end() ?>