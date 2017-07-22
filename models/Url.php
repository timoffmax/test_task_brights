<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "url".
 *
 * @property integer $id
 * @property string $url
 * @property string $title
 * @property integer $status_code
 * @property integer $processed
 */
class Url extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'url';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['url'], 'required'],
            [['status_code', 'processed'], 'integer'],
            [['url'], 'string', 'max' => 250],
            [['title'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Url',
            'title' => 'Title',
            'status_code' => 'Status Code',
            'processed' => 'Processed',
        ];
    }
}
