<?php

use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    // [
    // 'class'=>'\kartik\grid\DataColumn',
    // 'attribute'=>'id',
    // ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'rows_no',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'note',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'hAlign' => 'center',
        'label' => 'Status',
        'vAlign' => 'middle',
        'value' => function ($model) {
            if ($model->status == \common\models\BookShelf::STATUS_NOT_ACTIVE) {
                return 'Not Active';
            }
            if ($model->status == \common\models\BookShelf::STATUS_ACTIVE) {
                return 'Active';
            }
            if ($model->status == \common\models\BookShelf::STATUS_DELETED) {
                return 'Deleted';
            }
            return $model->status;
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign' => 'middle',
        'urlCreator' => function ($action, $model, $key, $index) {
            return Url::to([$action, 'id' => $key]);
        },
        'viewOptions' => ['role' => 'modal-remote', 'title' => 'View', 'data-toggle' => 'tooltip'],
        'updateOptions' => ['role' => 'modal-remote', 'title' => 'Update', 'data-toggle' => 'tooltip'],
        'deleteOptions' => ['role' => 'modal-remote', 'title' => 'Delete',
            'data-confirm' => false, 'data-method' => false,// for overide yii data api
            'data-request-method' => 'post',
            'data-toggle' => 'tooltip',
            'data-confirm-title' => 'Are you sure?',
            'data-confirm-message' => 'Are you sure want to delete this item'],
    ],

];   