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
        var form = $("#url-form");
        var button = form.find('button');
        var ajaxLoader = $("#ajax-loader-div");
        var table = $("#urls-table");
        
        button.on("click", function(event) {
            // Disable submit button
            button.prop('disabled', true);
            
            // Show ajax-loader
            ajaxLoader.removeClass('hidden');
            table.addClass('hidden');
            
            // AJAX query
            $.ajax({
                type: "POST",
                url: form.attr('action'),
                data: form.serialize(),
                success: function(data) {
                    // Enable button again
                    button.prop('disabled', false);
                    
                    // Clear form
                    form.find("textarea").val("");
                    
                    // Reload list of URLs
                    $.pjax.reload({container:"#pjax-urls"});
                    
                    // Hide ajax-loader
                    ajaxLoader.addClass('hidden');
                    table.removeClass('hidden');
                },
                error: function(data) {
                    // Hide ajax-loader
                    ajaxLoader.addClass('hidden');
                    table.removeClass('hidden');
                    
                    // Enable button again                    
                    button.prop('disabled', false);
                    alert('URLs adding error!');                                     
                }
            });
            
            // Prevent default action
            event.preventDefault();
            return false;
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
                'enableAjaxValidation' => true,
                'validationUrl' => 'form-validate',
                'options' => [
                    'class' => 'form-horizontal',
                ],
            ]);
        ?>

        <?= $form->field($formModel, 'urls')->textarea()->label(false) ?>

        <div class="form-group">
            <?= Html::button('Check URLs', ['class' => 'btn btn-success']) ?>
        </div>

        <?= $form->errorSummary($formModel) ?>

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

        <!--Image for display while data loading-->
        <div class="col-md-12 center-clock text-center hidden" id="ajax-loader-div">
            <?= Html::img('@web/images/ajax-loader.gif') ?>
        </div>

        <?=
            GridView::widget([
                'dataProvider' => $urlProvider,
                'id' => 'urls-table',
                'columns' => [
                    'url',
                    'status_code',
                    'title',
                    'check_time'
                ]
            ])
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>
