<?php

namespace app\controllers;


use app\models\Url;
use app\models\UrlForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class UrlController extends Controller
{
    public function actionIndex()
    {
        $formModel = new UrlForm();

        // Get all data from table 'url'
        $urls = Url::find();

        $urlProvider = new ActiveDataProvider([
            'query' => $urls,
            'pagination' => [
                'pageSize' => 50,
            ]
        ]);

        if (\Yii::$app->request->isPost) {
            sleep(10);
            var_dump(\Yii::$app->request->post());

            return $this->renderAjax(
                'index',
                compact('formModel', 'urlProvider')
            );
        }

        return $this->render(
            'index',
            compact('formModel', 'urlProvider')
        );
    }

    public function actionAdd()
    {
        if (\Yii::$app->request->isPost) {
            var_dump(\Yii::$app->request->post());
        }

        if (\Yii::$app->request->isPjax) {

        }

        return $this->renderAjax('index');
//        throw new \Exception('This page only for PJAX requests.');
    }
}