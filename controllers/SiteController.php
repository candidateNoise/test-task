<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionImport()
    {
        $model = new \app\models\ImportForm();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
                if ($model->validate()) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('success', 'Import completed');
                        return $this->refresh();
                    } else {
                        Yii::$app->session->setFlash('error', 'Import failed');
                    }
                }
            }
        }

        return $this->render('import', [
            'model' => $model
        ]);
    }

    public function actionSearch()
    {
        $searchModel = new \app\models\SearchForm();

        $query = \app\models\ImportData::find();

        if (Yii::$app->request->isGet) {
            if ($searchModel->load(Yii::$app->request->get())) {
                $team = \app\models\Team::find()->where([
                    'like', 'name', $searchModel->search_phrase
                ])->all();

                if ($team) {
                    $query->orWhere([
                        'team_id' => \yii\helpers\ArrayHelper::getColumn($team, 'id')
                    ]);
                }

                $query->orFilterWhere([
                    'OR',
                    ['like', 'name', $searchModel->search_phrase],
                    ['like', 'address', $searchModel->search_phrase]
                ]);
            }
        }

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query
        ]);

        return $this->render('search', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }
}
