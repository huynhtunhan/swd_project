<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "book_detail".
 *
 * @property int $ISBN
 * @property int $book_category_id
 */
class BookDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ISBN', 'book_category_id'], 'integer'],
            [['ISBN', 'book_category_id'], 'unique', 'targetAttribute' => ['ISBN', 'book_category_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ISBN' => 'Isbn',
            'book_category_id' => 'Book Category ID',
        ];
    }
}
