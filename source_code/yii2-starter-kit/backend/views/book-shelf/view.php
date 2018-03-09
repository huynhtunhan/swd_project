<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\BookShelf */
?>
<div class="book-shelf-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'rows_no',
            'note',
            [
                'label' => 'Status',
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
        ],
    ]) ?>

</div>
