<?php

namespace frontend\controllers;

use common\models\Modifiers;
use common\models\Order;
use Yii;
use common\models\Product;
use common\models\Productset;
use common\models\Setmenu;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    /**
     * Lists all Product for shop.
     * @return mixed
     */
    public function actionShop()
    {
        // Initailize cart if cart session have not been initialized
        $session = Yii::$app->session;
        if(!$session['cart'])
        {   
            $session['cart'] = array();
        }

        // Initializing session info
        if(!$session['info'])
        {
            $session['info']=['shift'=>'Un-chosen','cashier'=>'Un-Provided'];
            
        }

        
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
        ]);

        return $this->render('shop', [
            'dataProvider' => $dataProvider,
            'view' => '_product',
        ]);
    }


    /**
     * Providing data for set page
     * @return mixed
     */
    public function actionSet()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Setmenu::find(),
        ]);

        return $this->render('shop', [
            'dataProvider' => $dataProvider,
            'view' => '_set',
        ]);
    }




    /**
     * Adding set menus to cart and re-rendering the cart section
     * @return mixed
     */
    public function actionSetadd()
    {

        $request = Yii::$app->request;
        $session = Yii::$app->session;

        $sid= $request->get('sid');
        $qty= $request->get('qty');

        

        $added= false;

        $tmp_arry=[];
        $tmp_arry=$session['cart'];

        // checking if the item already existis in the cart
    
        foreach($tmp_arry as $key=>$line)
        {
            if($line['type']=='set')
            {
                if($line['set_id'] == $sid)
                {
                    
                    $tmp_arry[$key]['set_qty'] = $line['set_qty']+$qty;
                    $session['cart'] = $tmp_arry;
                    $added= true;
                }
            }
        }



        // Find the related set menu.
        $data_pass= array();
        $setmenu= Setmenu::findOne($sid);
        $set_products = $setmenu->products;
        
        foreach($set_products as $item)
        {
            $sqty=Productset::find()->andWhere(['set_id'=>$sid])->andWhere(['product_id'=>$item->id])->one()->qty;
            array_push($data_pass,['item_name'=>$item->name,'item_qty'=>$sqty]);
        }
        
        
        
        // Adding to session cart
        if(!$added)
        {
        
        $tmp_arry=[];
        $tmp_arry=$session['cart'];

        array_push($tmp_arry,['type'=>'set','set_id'=>$sid,'set_name'=>$setmenu->name,
        'set_qty'=>$qty,'set_price'=>$setmenu->price,'include'=>$data_pass]);

        $session['cart'] = $tmp_arry;
        }

        $cat=Yii::$app->createController('checkout/subtotal');

        $cat=$cat[0]; 

        $subtotal=$cat->actionSubtotal();
        return $this->renderPartial('_cart',['item'=>$session['cart'],'subtotal'=>$subtotal]);
    }





    /**
     * Adding products to cart and rendering the cart.
     * @return mixed
     */
    public function actionCart()
    {
        $request = Yii::$app->request;
        $session = Yii::$app->session;

        $pid= $request->get('pid');

        $product = Product::findOne($pid);
        $qty= $request->get('qty');
        $modifiers = $request->get('modifiers');
        $modifier_array = array();
        $added= false;

        if(!$modifiers){
        

        $tmp_arry=[];
        $tmp_arry=$session['cart'];
        // checking if the item already existis in the cart
        // Maybe update the cart uasage if you have time.
        
        foreach($tmp_arry as $key=>$line)
        {
            if ($line['type']=='product')
            {
                if($line['product_id'] == $pid && empty($line['modifiers']))
                {
                    
                    $tmp_arry[$key]['product_qty'] = $line['product_qty']+$qty;
                    $session['cart'] = $tmp_arry;
                    $added= true;
                }
            }
        }
        }

        // Modifiers Section. 

        if($modifiers)
        {
            foreach($modifiers as $m)
            {
            $modifier = Modifiers::findOne($m['modifier_id']);

            array_push($modifier_array,['modifier_id'=>$modifier->id,'modifier_qty'=>$m['modifier_qty']
            ,'modifier_name'=>$modifier->name,'modifier_price'=>$modifier->price]);
        
        }
        }
        // Add to session and render the result into the _cart php
        if(!$added)
        {

            $tmp_arry=[];
            $tmp_arry=$session['cart'];
    
            array_push($tmp_arry,['type'=>'product','product_id'=>$pid, 'product_name'=>$product->name, 'product_qty'=>$qty,
            'product_price' => $product->price,
            'modifiers'=>$modifier_array]);
    
            $session['cart'] = $tmp_arry;
        }
      

        // Passing subtotal data
        $cat=Yii::$app->createController('checkout/subtotal');

        $cat=$cat[0]; 

        $subtotal=$cat->actionSubtotal();

        return $this->renderAjax('_cart',['item'=>$session['cart'],'subtotal'=>$subtotal]);


    }


    /**
     * Removing items from the cart and re-rendering the cart section
     * @return mixed
     */
    public function actionRemove($data)
    {
        
        $session = Yii::$app->session;

        if(!str_starts_with($data,'.'))
        {
        $tmp_arry=[];
        $tmp_arry=$session['cart'];
        unset($tmp_arry[$data]);
        $session['cart'] = $tmp_arry; 
        }
        else
        {
            $pieces= explode('.',$data);
            $first_index = (int)$pieces[1];
            $second_index = (int)$pieces[2];
            $tmp_arry=[];
            $tmp_arry=$session['cart'];
            unset($tmp_arry[$first_index]['modifiers'][$second_index]);
            $session['cart'] = $tmp_arry; 
        }

        $cat=Yii::$app->createController('checkout/subtotal');

        $cat=$cat[0]; 

        $subtotal=$cat->actionSubtotal();

        return $this->renderAjax('_cart',['item'=>$session['cart'],'subtotal'=>$subtotal]);
    }


    // Functions in helping development process

    public function actionTest()
    {
        $session = Yii::$app->session;
        $url= Yii::$app->request->queryParams['r'];
        
        return print_r($session['cart']);
    }
    public function actionClear()
    {

        $session = Yii::$app->session;
        $session['cart']=[];

    } 

    // Mostly Generated methods 

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {

        
        $dataProvider = new ActiveDataProvider([
            'query' => Product::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if(Yii::$app->request->isPost)
        {
            $model->image_tmp =UploadedFile::getInstance($model,'image');
 
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
