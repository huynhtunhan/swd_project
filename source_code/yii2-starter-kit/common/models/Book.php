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
 * @property int $status
 */
class Book extends \yii\db\ActiveRecord
{
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

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
            [['ISBN', 'author', 'title', 'publisher', 'date', 'quantity', 'amount_of_loan', 'on_loan', 'status'], 'required'],
            [['ISBN', 'quantity', 'amount_of_loan', 'on_loan', 'book_shelf_id', 'status'], 'integer'],
            ['quantity', 'compare', 'compareAttribute' => 'amount_of_loan', 'operator' => '>=', 'type' => 'number'],
            ['amount_of_loan', 'compare', 'compareAttribute' => 'quantity', 'operator' => '<=', 'type' => 'number'],
            [['date'], 'safe'],
            [['author', 'title', 'publisher'], 'string', 'max' => 500],
            [['ISBN'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ISBN' => 'ISBN',
            'author' => 'Author',
            'title' => 'Title',
            'publisher' => 'Publisher',
            'date' => 'Date',
            'quantity' => 'Quantity',
            'amount_of_loan' => 'Amount Of Loan',
            'on_loan' => 'On Loan',
            'book_shelf_id' => 'Book Shelf ID',
            'status' => 'Status',
        ];
    }

    /**
     * Returns user statuses list
     * @return array|mixed
     */
    public static function statuses()
    {
        return [
            self::STATUS_NOT_ACTIVE => Yii::t('common', 'Not Active'),
            self::STATUS_ACTIVE => Yii::t('common', 'Active'),
            self::STATUS_DELETED => Yii::t('common', 'Deleted')
        ];
    }

    /**
     * Returns user statuses list
     * @return array|mixed
     */
    public static function getBookDetailByID($id)
    {
        $bookCategory = BookDetail::find()->where(['ISBN' => $id])->all();

        $modelCategory = '';
        if ($bookCategory != null) {
            for ($i = 0; $i < sizeof($bookCategory); $i++) {
                if ($i == sizeof($bookCategory) - 1) {
                    $modelCategory = $modelCategory . BookCategory::getBookCategoryByID(($bookCategory[$i])->book_category_id);
                } else {
                    $modelCategory = $modelCategory . BookCategory::getBookCategoryByID(($bookCategory[$i])->book_category_id) . ', ';
                }
            }
        }
        return $modelCategory;
    }
}
