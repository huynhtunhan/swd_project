<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "book_shelf".
 *
 * @property int $id
 * @property int $rows_no
 * @property string $note
 * @property int $status
 */
class BookShelf extends \yii\db\ActiveRecord
{
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book_shelf';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rows_no', 'status'], 'required'],
            [['rows_no', 'status'], 'integer'],
            [['note'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rows_no' => 'Rows No',
            'note' => 'Note',
            'status' => 'Status',
        ];
    }

    public static function BookShelf()
    {
        return ArrayHelper::map(BookShelf::find()->where(['status' => self::STATUS_ACTIVE])->all(), 'id', 'rows_no');
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
}
