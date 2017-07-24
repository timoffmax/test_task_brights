<?php

namespace app\models;

use DOMDocument;
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


    /**
     * Parsing HTML document and returning page title
     *
     * @param string $url
     * @return string
     */
    public static function getTitleByUrl(string $url) : string
    {
        try {
            // Get page
            $htmlPage = file_get_contents($url);

            // Parsing HTML document
            $htmlDocument = new DOMDocument();
            @$htmlDocument->loadHTML($htmlPage);
            $nodes = $htmlDocument->getElementsByTagName('title');

            //get and display what you need:
            $title = $nodes->item(0)->nodeValue;
        } catch (\Exception $e) {
            $title = '';
        }

        return $title ?? '';
    }
}
