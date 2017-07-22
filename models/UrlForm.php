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
            [['urls'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'urls' => 'URLs',
        ];
    }
}