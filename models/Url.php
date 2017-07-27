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
 * @property  $check_time
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
            [['status_code'], 'integer'],
            [['url'], 'string', 'max' => 250],
            [['url'], 'url'],
            [['title'], 'string', 'max' => 150],
            [['check_time'], 'date' ,'format' => 'php:U'],
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
            'check_time' => 'Check Time',
        ];
    }


    /**
     * Parsing HTML document and returning page title and status code
     *
     * @param string $url
     * @return array
     */
    public static function getUrlInfo(string $url) : array
    {
        /*
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
        */

        // Create cURL resource, get HTML document
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $htmlPage = curl_exec($ch);

        // Parsing HTML document
        $htmlDocument = new DOMDocument();
        @$htmlDocument->loadHTML($htmlPage);
        $nodes = $htmlDocument->getElementsByTagName('title');

        // Get title
        $title = $nodes->item(0)->nodeValue ?? '';

        // Get status code
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE) ?? 0;

        return compact('title', 'statusCode');
    }
}
