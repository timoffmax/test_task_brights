<?php

namespace app\controllers;


use app\models\Url;
use app\models\UrlForm;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\web\Controller;

class UrlController extends Controller
{
    public function actionIndex()
    {
        $formModel = new UrlForm();

        if (\Yii::$app->request->isAjax) {
            if ($formModel->load(\Yii::$app->request->post()) && $formModel->validate()) {
                // Split string to array by line endings
                $urls = explode('\n', str_replace("\r", "", $formModel->urls));

                // Visit all URLs and write result to table
                $this->processingUrls($urls);

                return true;
            }

            throw new \Exception('Error form validation');
        }

        // Get all data from table 'url'
        $urls = Url::find();

        $urlProvider = new ActiveDataProvider([
            'query' => $urls,
            'pagination' => [
                'pageSize' => 50,
            ]
        ]);

        return $this->render(
            'index',
            compact('formModel', 'urlProvider')
        );
    }

    public function actionAdd()
    {

    }

    public function actionTest($url)
    {
        Url::getTitleByUrl($url);
    }

    private function processingUrls(array $urls)
    {
        foreach ($urls as $url) {
            $row = new Url();
            $row->title = Url::getTitleByUrl($url);
        }
    }
}