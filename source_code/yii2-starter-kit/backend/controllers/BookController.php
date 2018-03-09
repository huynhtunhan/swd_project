<?php

namespace backend\controllers;

use common\models\BookCategory;
use common\models\BookDetail;
use DateTime;
use Yii;
use common\models\Book;
use backend\models\search\BookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;

        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Book #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new Book model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Book();
        $model->on_loan = 0;
        $model->status = Book::STATUS_ACTIVE;

        $modelCategory = new BookDetail();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Create new Book",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                        'modelCategory' => $modelCategory,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            } else if ($model->load($request->post()) && $model->validate()) {
                $model->date = date_format(new DateTime($model->date), 'Y-m-d');
                if ($model->save()) {
                    if ($modelCategory->load($request->post())) {
                        if ($modelCategory->book_category_id != null) {
                            foreach ($modelCategory->book_category_id as $item) {
                                $modelCategory1 = new BookDetail();
                                $modelCategory1->book_category_id = $item;
                                $modelCategory1->ISBN = $model->ISBN;
                                $modelCategory1->save();
                            }
                        }
                    }
                    return [
                        'forceReload' => '#crud-datatable-pjax',
                        'title' => "Create new Book",
                        'content' => '<span class="text-success">Create Book success</span>',
                        'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                            Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])

                    ];
                }
            } else {
                return [
                    'title' => "Create new Book",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                        'modelCategory' => $modelCategory,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $modelCategory->load($request->post())) {
                $model->date = date_format(new DateTime($model->date), 'Y-m-d');
                if ($model->save()) {
                    if ($modelCategory->load($request->post())) {
                        if ($modelCategory->book_category_id != null) {
                            foreach ($modelCategory->book_category_id as $item) {
                                $modelCategory1 = new BookDetail();
                                $modelCategory1->book_category_id = $item;
                                $modelCategory1->ISBN = $model->ISBN;
                                $modelCategory1->save();
                            }
                        }
                    }
                    return $this->redirect(['view', 'id' => $model->ISBN]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'modelCategory' => $modelCategory,
                ]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'modelCategory' => $modelCategory,
        ]);
    }

    /**
     * Updates an existing Book model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $modelCategory = new BookDetail();
        $bookCategory = BookDetail::find()->where(['ISBN' => $id])->all();
        $checkedList = [];
        if ($bookCategory != null) {
            foreach ($bookCategory as $item) {
                array_push($checkedList, $item->book_category_id);
            }
        }
        $modelCategory->book_category_id = $checkedList;

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update Book #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                        'modelCategory' => $modelCategory,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                if ($modelCategory->load($request->post())) {
                    if ($modelCategory->book_category_id != null) {
                        //remove all BookDetail
                        if ($bookCategory != null) {
                            foreach ($bookCategory as $item) {
                                $item->delete();
                            }
                        }
                        foreach ($modelCategory->book_category_id as $item) {
                            //update new BookDetail
                            $modelCategory1 = new BookDetail();
                            $modelCategory1->book_category_id = $item;
                            $modelCategory1->ISBN = $model->ISBN;
                            $modelCategory1->save();
                        }
                    } else {
                        //remove all BookDetail
                        if ($bookCategory != null) {
                            foreach ($bookCategory as $item) {
                                $item->delete();
                            }
                        }
                    }
                }
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Book #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update Book #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                        'modelCategory' => $modelCategory,
                    ]),
                    'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                if ($modelCategory->load($request->post())) {
                    if ($modelCategory->book_category_id != null) {
                        //remove all BookDetail
                        if ($bookCategory != null) {
                            foreach ($bookCategory as $item) {
                                $item->delete();
                            }
                        }
                        foreach ($modelCategory->book_category_id as $item) {
                            //update new BookDetail
                            $modelCategory1 = new BookDetail();
                            $modelCategory1->book_category_id = $item;
                            $modelCategory1->ISBN = $model->ISBN;
                            $modelCategory1->save();
                        }
                    } else {
                        //remove all BookDetail
                        if ($bookCategory != null) {
                            foreach ($bookCategory as $item) {
                                $item->delete();
                            }
                        }
                    }
                }
                return $this->redirect(['view', 'id' => $model->ISBN]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'modelCategory' => $modelCategory,
                ]);
            }
        }
    }

    /**
     * Delete an existing Book model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();
        $bookDetail = BookDetail::find()->where(['ISBN' => $id])->all();
        if ($bookDetail != null) {
            foreach ($bookDetail as $item) {
                $item->delete();
            }
        }
        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

    /**
     * Delete multiple existing Book model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();

            $bookDetail = BookDetail::find()->where(['ISBN' => $pk])->all();
            if ($bookDetail != null) {
                foreach ($bookDetail as $item) {
                    $item->delete();
                }
            }
        }

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }

    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
