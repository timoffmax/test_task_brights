<?php
use dosamigos\chartjs\ChartJs;
/** @var array $datasets */
/** @var array $dates */

$this->title = 'Statistics';
?>

<div class="row">
    <h2>Statistics</h2>
</div>
<div class="row">
    <div class="col-md-12">
        <?=
        ChartJs::widget([
            'type' => 'bar',
        'options' => [
            'height' => 500,
            'width' => 1200
        ],
            'data' => [
                'labels' => $dates,
                'datasets' => $datasets
            ],
            'clientOptions' => [
                'legend' => [
                    'position' => 'bottom'
                ],
                'scales' => [
                    'yAxes' => [
                        [
                            'scaleLabel' => [
                                'display' => 'true',
                                'labelString' => 'Count of checks'
                            ]
                        ]
                    ],
                    'xAxes' => [
                        [
                            'scaleLabel' => [
                                'display' => 'true',
                                'labelString' => 'Date'
                            ]
                        ]
                    ]
                ],

            ]
        ]);
        ?>
    </div>
</div>
