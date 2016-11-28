<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = 'Search';
$this->params['breadcrumbs'][] = $this->title;

?>

<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
    <?php $form = ActiveForm::begin([
        'id' => 'search-form',
        'method' => 'get',
        'action' => Url::to([
            'site/search'
        ])
    ]); ?>

        <div class="col-lg-6">
            <?= $form->field($searchModel, 'search_phrase', [
                'template' => '{input} {error}'
            ])->textInput([
                'placeholder' => 'Enter search phrase'
            ]); ?>
        </div>

        <div class="col-lg-6">
            <?= Html::submitButton('Find', ['class' => 'btn btn-primary']); ?>
            <?= Html::button('Reset', [
                'class' => 'btn btn-danger',
                'onclick' => 'window.location.href = \''. Url::to(['site/search']).'\';'
            ]); ?>
        </div>

    <?php ActiveForm::end(); ?>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'name',
                        'format' => 'raw',
                        'value' => function ($model) use ($searchModel) {
                            return $model->phraseHighlight($model->name, $searchModel->search_phrase);
                        }
                    ],
                    'age',
                    [
                        'attribute' => 'address',
                        'format' => 'raw',
                        'value' => function ($model) use ($searchModel) {
                            return $model->phraseHighlight($model->address, $searchModel->search_phrase);
                        }
                    ],
                    [
                        'attribute' => 'team_id',
                        'format' => 'raw',
                        'value' => function ($model) use ($searchModel) {
                            return $model->phraseHighlight($model->team->name, $searchModel->search_phrase);
                        }
                    ]
                ]
            ]); ?>
        </div>
    </div>
</div>