<?php
use yii\helpers\Html;
use yii\helpers\Url;

date_default_timezone_set('Asia/Yangon');

?>


<div class="content-wrap w-50 mx-auto">

<h5 class="text-center">
    ABCDE SNACKS <br>
    Mandalay City, <br>
    South Okkalapa Tsp, <br>
    Hleden U Tun Lin Chan St.

</h5>
<div class='font-weight-light'>
Receipt No. <?= $order_id ?>
<?php 
        echo "<hr>";
        echo date("m/d/Y")." ".date("H:i:s")."<br>";
        echo "Shift:  ".$info['shift']." | ";
        echo "Cashier:  ".$info['cashier']."<br>";
        echo $ordertype;
        echo "<hr>";
        echo "</div>";  
?>

<table class="w-100">

 
<?php
    foreach($item as $key=>$i)
    {   
        
        try{
            echo "<tr>";
            echo  "<td class='font-italic'>".$i['set_qty']."<span>x</span></td>";
            echo  "<td>".$i['set_name']."</td>";
            echo "<td>".Yii::$app->formatter->asCurrency($i['set_price'])."</td>";
            echo "<td class='text-right'>....".Yii::$app->formatter->asCurrency($i['set_qty']*$i['set_price'])."</td>";
            echo "</tr>";

            // What is included in the set. 
            // echo "<tr><td>each contains.</td></tr>";
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
            echo "<td  class='text-right'>....".Yii::$app->formatter->asCurrency($i['product_qty']*$i['product_price'])."</td>";
            echo "</tr>";

            foreach($i['modifiers'] as $mkey=>$m)
            {
                echo "<tr class='sub-text'>";
                echo  "<td class='font-italic'><b>".$m['modifier_qty']."x</b></td>";
                echo  "<td><b>".$m['modifier_name']."</b></td>";
                echo "<td><b>".Yii::$app->formatter->asCurrency($m['modifier_price'])."</b></td>";
                echo "<td class='text-right'><b>....".Yii::$app->formatter->asCurrency($m['modifier_qty']*$m['modifier_price'])."</b></td>";
                echo "</tr>";
            }
        }
        
        
        
    }
?>

</table>

<?php
    echo "<hr>";
    echo "<div class='checkout-bottom font-weight-light'>";
    echo "<p>Subtotal  ".Yii::$app->formatter->asCurrency($subtotal)."<br>Discount  ".
    $discount." %<br>Grand Total  ".Yii::$app->formatter->asCurrency($grandtotal).
    "<br>Payment  ".$payment."</p>";
    echo "</div>";

?>
<hr>
<div class="checkout-footer font-weight-bold" style='font-size:small;'>
CUSTOMER HOTLINE <br>
(090) 03 27595 8889 <br>
***Thank You!***
</div>

<div class="checkout-footer-butttons float-right">

<!-- Need to be a form that pass some data (insert) -->
<?= HTML::a('Checkout',Url::toRoute(['checkout/insert','id'=>$order_id]),['class'=>'btn btn-info']) ?>
</div>

</div>