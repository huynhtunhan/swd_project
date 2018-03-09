<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BookCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->widget(\kartik\select2\Select2::classname(), [
        'data' => \common\models\BookCategory::statuses(),
        'options' => ['placeholder' => 'Select a status ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>


    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>
