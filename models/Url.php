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

    /**
     * Prepare data for using in ChartJS widget later
     *
     * @param array $statistics
     * @param array $dates
     * @return array
     */
    public static function prepareDatasetsForChart(array $statistics, array $dates) : array
    {
        $datasets = [];

        // Get checks for each day with this status code
        foreach ($statistics as $statusCode => $results) {
            $checks = [];

            foreach ($dates as $date) {
                $checks[] = $results[$date]['checks'] ?? 0;
            }

            // Merge data with chart color options
            $datasets[] = array_merge(
                [
                    'label' => $statusCode,
                    'data' => $checks,
                ],
                Url::getColorSchemeByStatusCode($statusCode)
            );
        }

        return $datasets;
    }

    /**
     * Return different color schemes for ChartJS widget with depends of status code
     *
     * @param int $statusCode
     * @return array
     */
    public static function getColorSchemeByStatusCode(int $statusCode) : array
    {
        switch ($statusCode) {
            case 0:
            default:
                $colorScheme = [
                    'backgroundColor' => "rgba(176,48,96,0.2)",
                    'borderColor' => "rgba(176,48,96,1)",
                    'pointBackgroundColor' => "rgba(176,48,96,1)",
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(176,48,96,1)",
                ];
                break;

            // 1XX codes
            case (preg_match('/1\d\d/', $statusCode) ? true : false):
                $colorScheme = [
                    'backgroundColor' => "rgba(255,99,71,0.2)",
                    'borderColor' => "rgba(255,99,71,1)",
                    'pointBackgroundColor' => "rgba(255,99,71,1)",
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(255,99,71,1)",
                ];
                break;

            // 2XX codes
            case (preg_match('/2\d\d/', $statusCode) ? true : false):
                $colorScheme = [
                    'backgroundColor' => "rgba(0,100,0,0.2)",
                    'borderColor' => "rgba(0,100,0,1)",
                    'pointBackgroundColor' => "rgba(0,100,0,1)",
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(0,100,0,1)",
                ];
                break;

            // 3XX codes
            case (preg_match('/3\d\d/', $statusCode) ? true : false):
                $colorScheme = [
                    'backgroundColor' => "rgba(100,149,237,0.2)",
                    'borderColor' => "rgba(100,149,237,1)",
                    'pointBackgroundColor' => "rgba(100,149,237,1)",
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(100,149,237,1)",
                ];
                break;

            // 4XX codes
            case (preg_match('/4\d\d/', $statusCode) ? true : false):
                $colorScheme = [
                    'backgroundColor' => "rgba(218,165,32,0.2)",
                    'borderColor' => "rgba(218,165,32,1)",
                    'pointBackgroundColor' => "rgba(218,165,32,1)",
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(218,165,32,1)",
                ];
                break;

            // 5XX codes
            case (preg_match('/5\d\d/', $statusCode) ? true : false):
                $colorScheme = [
                    'backgroundColor' => "rgba(47,79,79,0.2)",
                    'borderColor' => "rgba(47,79,79,1)",
                    'pointBackgroundColor' => "rgba(47,79,79,1)",
                    'pointBorderColor' => "#fff",
                    'pointHoverBackgroundColor' => "#fff",
                    'pointHoverBorderColor' => "rgba(47,79,79,1)",
                ];
                break;
        }

        return $colorScheme;
    }
}
