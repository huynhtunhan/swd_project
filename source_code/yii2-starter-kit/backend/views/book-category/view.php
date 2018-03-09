<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\BookCategory */
?>
<div class="book-category-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'label' => 'Status',
                'value' => function ($model) {
                    if ($model->status == \common\models\BookCategory::STATUS_NOT_ACTIVE) {
                        return 'Not Active';
                    }
                    if ($model->status == \common\models\BookCategory::STATUS_ACTIVE) {
                        return 'Active';
                    }
                    if ($model->status == \common\models\BookCategory::STATUS_DELETED) {
                        return 'Deleted';
                    }
                    return $model->status;
                }
            ],
        ],
    ]) ?>

</div>
