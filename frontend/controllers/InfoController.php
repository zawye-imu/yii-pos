<?php

namespace frontend\controllers;


use Yii;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Info Controller
 */
class InfoController extends Controller
{   

    /**
     * Showing info page and saving updated data
     * @return mixed
     */
    public function actionIndex()
    {
        $session=Yii::$app->session;
        $request=Yii::$app->request;

        if($request->isPost)
        {
        
        
            $tmp_array= $session['info'];
            $tmp_array['shift']=$request->post('shift');
            $tmp_array['cashier']=$request->post('cashier');
            $session['info']=$tmp_array;
            Yii::$app->session->setFlash('success', "Data Added Successfully."); 
            return $this->redirect(Url::toRoute('info/index'));
        }

        return $this->render('index',['items'=>$session['info']]);
    }


}