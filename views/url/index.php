<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/** @var \app\models\UrlForm $formModel */
/** @var \yii\data\ActiveDataProvider $urlProvider */

$this->title = 'URLs';

$js = <<<JS
    $("document").ready(function(){
        $("#pjax-url-form").on("pjax:start", function() {
            $(this).find('button[type=submit]').prop('disabled', true);
            alert('Test');
        });
        
        $("#pjax-url-form").on("pjax:end", function() {
            $.pjax.reload({container:"#pjax-urls"});
        });
    });
JS;
$this->registerJs($js);
?>

<!--Form for adding new URLs-->
<div class="row col-md-12">
    <div class="row">
        <h2>Add new URLs</h2>
    </div>
    <div class="row">
        <?php Pjax::begin(['id' => 'pjax-url-form']); ?>
        <?php
            $form = ActiveForm::begin([
                'id' => 'url-form',
//                'action' => 'url/add',
                'options' => [
                    'class' => 'form-horizontal',
                    'data-pjax' => true,
                ],
            ]);
        ?>

        <?= $form->field($formModel, 'urls')->textarea()->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton('Check URLs', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        <?php Pjax::end(); ?>
    </div>
</div>

<!--Table with check results-->
<div class="row col-md-12">
    <div class="row">
        <h2>Checked URLs</h2>
    </div>
    <div class="row">
        <?php Pjax::begin(['id' => 'pjax-urls']); ?>
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
