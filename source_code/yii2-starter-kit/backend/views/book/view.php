<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Book */
?>
<div class="book-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'ISBN',
            'author',
            'title',
            'publisher',
            [
                'label' => 'Category',
                'value' => function ($model) {
                    return \common\models\Book::getBookDetailByID($model->ISBN);
                }
            ],
            'date',
            'quantity',
            'amount_of_loan',
            'on_loan',
            'book_shelf_id',
            [
                'label' => 'Status',
                'value' => function ($model) {
                    if ($model->status == \common\models\Book::STATUS_NOT_ACTIVE) {
                        return 'Not Active';
                    }
                    if ($model->status == \common\models\Book::STATUS_ACTIVE) {
                        return 'Active';
                    }
                    if ($model->status == \common\models\Book::STATUS_DELETED) {
                        return 'Deleted';
                    }
                    return $model->status;
                }
            ],
        ],
    ]) ?>

</div>
