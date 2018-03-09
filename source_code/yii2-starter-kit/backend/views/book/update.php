<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Book */
?>
<div class="book-update">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ISBN')->textInput()->label('ISBN') ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'publisher')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelCategory, 'book_category_id')->checkboxList(\common\models\BookCategory::category())->label('Category') ?>

    <?= $form->field($model, 'date')->widget(\kartik\date\DatePicker::className(), [
        'value' => date('d-M-Y', strtotime('+2 days')),
        'options' => ['placeholder' => 'Select a date ...'],
        'pluginOptions' => [
            'format' => 'dd-M-yyyy',
            'todayHighlight' => true
        ]
    ]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'amount_of_loan')->textInput() ?>

    <?= $form->field($model, 'book_shelf_id')->widget(\kartik\select2\Select2::className(), [
        'data' => \common\models\BookShelf::BookShelf(),
        'options' => ['placeholder' => 'Select a book shelf ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Book Shelf No.') ?>

    <?= $form->field($model, 'status')->widget(\kartik\select2\Select2::classname(), [
        'data' => [
            0 => "Not Active",
            1 => "Active",
            2 => "Delete",
        ],
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
