<?php


namespace app\models;


use yii\base\Model;

class UrlForm extends Model
{
    public $urls;

    public function rules()
    {
        return [
            [['urls'], 'required'],
            [['urls'], 'trim'],
            [['urls'], 'string'],
            [['urls'], 'urlsValidator', 'message' => 'Some URLs is not valid!']
        ];
    }

    public function attributeLabels()
    {
        return [
            'urls' => 'URLs',
        ];
    }

    /**
     * Detect if one or more strings is not URL
     */
    public function urlsValidator()
    {
        // Split string to array by line endings
        $urls = preg_split('/\r\n|[\r\n]/', $this->urls);

        // Check each URL
        foreach ($urls as $url) {
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                $this->addError('urls', $url .' is not valid URL!');
            }
        }
    }
}