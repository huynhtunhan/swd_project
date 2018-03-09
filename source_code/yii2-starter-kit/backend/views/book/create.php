<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Book */
/* @var $modelCategory common\models\BookCategory */

?>
<div class="book-create">
    <?= $this->render('_form', [
        'model' => $model,
        'modelCategory' => $modelCategory,
    ]) ?>
</div>
