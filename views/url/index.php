<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/** @var \app\models\UrlForm $formModel */
/** @var \yii\data\ActiveDataProvider $urlProvider */

$this->title = 'URLs';

$js = <<<JS
    $("document").ready(function() {
        $("#url-form").on("submit", function() {
            // Set vars
            var button = $(this).find('button[type=submit]');
            
            // Disable submit button
            button.prop('disabled', true);
            
            // AJAX query
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(data) {
                    // var response = parseJSON(data);
                    console.log(data);

                    // Enable button again
                    button.prop('disabled', false);
                }
            });
            return false;
            
        });

        $("#pjax-url-form").on("pjax:success", function() {
            $.pjax.reload({container:"#pjax-urls"});
        });
    });
JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>

<!--Form for adding new URLs-->
<div class="row col-md-12">
    <div class="row">
        <h2>Add new URLs</h2>
    </div>
    <div class="row">
        <?php
            $form = ActiveForm::begin([
                'id' => 'url-form',
                'options' => [
                    'class' => 'form-horizontal',
                ],
            ]);
        ?>

        <?= $form->field($formModel, 'urls')->textarea()->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Check URLs', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<!--Table with check results-->
<div class="row col-md-12">
    <div class="row">
        <h2>Checked URLs</h2>
    </div>
    <div class="row">
        <?php
            Pjax::begin([
                'id' => 'pjax-urls',
                'enablePushState' => false,
                'timeout' => '5000',
            ]);
        ?>
        <?=
            GridView::widget([
                'dataProvider' => $urlProvider,
                'columns' => [
                    'url',
                    'status_code',
                    'title',
                ]
            ])
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>
