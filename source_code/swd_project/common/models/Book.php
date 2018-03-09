<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property int $ISBN
 * @property string $author
 * @property string $title
 * @property string $publisher
 * @property string $date
 * @property int $quantity
 * @property int $amount_of_loan
 * @property int $on_loan
 * @property int $book_shelf_id
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ISBN', 'author', 'title', 'publisher', 'date', 'quantity', 'amount_of_loan', 'on_loan', 'book_shelf_id'], 'required'],
            [['ISBN', 'quantity', 'amount_of_loan', 'on_loan', 'book_shelf_id'], 'integer'],
            [['date'], 'safe'],
            [['author', 'title', 'publisher'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ISBN' => 'Isbn',
            'author' => 'Author',
            'title' => 'Title',
            'publisher' => 'Publisher',
            'date' => 'Date',
            'quantity' => 'Quantity',
            'amount_of_loan' => 'Amount Of Loan',
            'on_loan' => 'On Loan',
            'book_shelf_id' => 'Book Shelf ID',
        ];
    }
}
