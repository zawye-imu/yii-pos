<?php

namespace frontend\controllers;

use common\models\Order;
use common\models\Orderitem;
use common\models\OrderItemModifiers;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Checkout Controller
 */
class CheckoutController extends Controller
{

    /**
     * Index action for saving data to the database and and showing checkout page.
     * @return mixed
     */
    public function actionIndex()
    {
        // save to order here with draft orderline modifiers line all +++ and change status to draft 
        $session = Yii::$app->session;
        $request = Yii::$app->request;

        if($request->isPost)
        {
            $discount=$request->post('discount');
            $payment=$request->post('payment');
            $order_type=$request->post('type');
            
            
            // Get info cart data
            $info_cart = $session['info'];
            $shift = $info_cart['shift'];
            $cashier = $info_cart['cashier'];

            // Calculating subtotal and grand total from cart 
            $subtotal = $this->actionSubtotal();


            $grandtotal = $subtotal - ($discount/100 * $subtotal);
            

            // Saving to the order as draft order
            $order = new Order();
            $order->status = 0;
            $order->payment = $payment;
            $order->shift = $shift;
            $order->cashier = $cashier;
            $order->dine = $order_type;
            $order->discount = $discount;
            $order->subtotal =$subtotal;
            $order->grandtotal  = $grandtotal;
            if($order->save())
            {
                $orderid= $order->id;

                // Saving the order items 
                $shopping_cart = $session->get('cart');
                foreach($shopping_cart as $line)
                {
                    if($line['type'] =='set')
                    {
                        $orderitem = new Orderitem();
                        $orderitem->set_id = $line['set_id'];
                        $orderitem->order_id = $orderid;
                        $orderitem->qty = $line['set_qty'];
                        if($orderitem->save())
                        {}
                        else
                        {
                            Yii::$app->session->setFlash('error','Please check your inputs.');
                            return $this->redirect(Url::toRoute('product/shop'));   
                        }
    
                    }
                    elseif($line['type'] =='product')
                    {
                        $orderitem = new Orderitem();
                        $orderitem->product_id = $line['product_id'];
                        $orderitem->order_id = $orderid;
                        $orderitem->qty = $line['product_qty'];
                        if($orderitem->save()){}
                        else{
                            Yii::$app->session->setFlash('error','Please check your inputs.');
                            return $this->redirect(Url::toRoute('product/shop'));
                        }
                        // Checking for modifiers and addings to orderitemsmodifiers table 
                        if(!empty($line['modifiers']))
                        {
                            foreach($line['modifiers'] as $ml)
                            {
                                $oim= new OrderItemModifiers();
                                $oim->orderitem_id= $orderitem->id;
                                $oim->modifier_id = $ml['modifier_id'];
                                $oim->qty = $ml['modifier_qty'];
                                if($oim->save()){}
                                else
                                {
                                    Yii::$app->session->setFlash('error','Please check your inputs.');
                                    return $this->redirect(Url::toRoute('product/shop'));
                                } 
                            }
                        }
    
                    }
                }

            }
            else
            {
                Yii::$app->session->setFlash('error','Please check your inputs.');
                return $this->redirect(Url::toRoute('product/shop'));
            }
                
        }
        
        return $this->render('checkout',['item'=>$session['cart'],'info'=>$session['info'],
        'discount'=>$discount,'payment'=> $payment,'ordertype'=>$order_type,'subtotal'=>$subtotal,
        'grandtotal'=> $grandtotal,'order_id'=>$orderid]);
    }

    /**
     * Subtotal action for calculating subtotal of current items in cart
     * @return float
     */
    public function actionSubtotal()
    {
        $session = Yii::$app->session;
        $shopping_cart = $session['cart'];
        $subtotal=0;
        foreach($shopping_cart as $line)
        {
            if($line['type'] == 'set')
            {
                $subtotal = $subtotal + ($line['set_price']*$line['set_qty']);

            }
            elseif($line['type'] == 'product')
            {
                $subtotal = $subtotal + ($line['product_qty']*$line['product_price']);

                if(!empty($line['modifiers']))
                {
                    foreach($line['modifiers'] as $ml)
                    {
                        $subtotal = $subtotal + ($ml['modifier_qty']*$ml['modifier_price']);
                    }
                }
            }

        }
        return $subtotal;
    }

    /**
     * Changing the status of the checkout order to 1 and clearing the cart. 
     * @return mixed
     */
    public function actionInsert($id)
    {
        $session = Yii::$app->session;
        $order = new Order();
        $current_order = $order->findOne($id);
        $current_order->status = 1;
        $current_order->save();

        // Clear the cart after 
        $session['cart']=[];
        Yii::$app->session->setFlash('success','One order done <i class="bi bi-emoji-laughing"></i>');
        return $this->redirect(Url::toRoute('product/shop'));

    }

}