<?php

namespace app\controllers;


use app\models\Url;
use app\models\UrlForm;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\Response;

class UrlController extends Controller
{

    /**
     * @return bool|string|array
     * @throws \Exception
     */
    public function actionIndex()
    {
        $formModel = new UrlForm();

        if (\Yii::$app->request->isAjax && !\Yii::$app->request->isPjax) {
            if ($formModel->load(\Yii::$app->request->post()) && $formModel->validate()) {
                // For animation test
                sleep(1);

                // Split string to array by line endings
                $urls = preg_split('/\r\n|[\r\n]/', $formModel->urls);

                // Visit all URLs and write results to table
                $result = $this->processingUrls($urls);

                return $result;
            }

            return false;
        }

        // Get all data from table 'url'
        $urls = Url::find();

        $urlProvider = new ActiveDataProvider([
            'query' => $urls,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);

        return $this->render(
            'index',
            compact('formModel', 'urlProvider')
        );
    }

    /**
     * Action for AJAX validation form with URLs
     *
     * @return array
     */
    public function actionFormValidate()
    {
        $formModel = new UrlForm();

        if (\Yii::$app->request->isAjax && $formModel->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($formModel);
        }
    }

    /**
     * Get info for each URL and save it to DB
     *
     * @param array $urls
     * @return bool
     */
    private function processingUrls(array $urls) : bool
    {
        foreach ($urls as $url) {
            // Prepare URL
            $url = trim($url);

            // Get title and status code
            $urlInfo =  Url::getUrlInfo($url);

            // Save to DB
            $row = new Url();
            $row->url = $url;
            $row->title = $urlInfo['title'];
            $row->status_code = $urlInfo['statusCode'];
            if (!$row->save()) {
                return false;
            }
        }

        return true;
    }
}