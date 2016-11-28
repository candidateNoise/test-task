<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Import';
$this->params['breadcrumbs'][] = $this->title;

$flashes = Yii::$app->session->getAllFlashes();

?>

<div>
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-6">
        <?php if (isset($flashes['success'])): ?>
            <?= $flashes['success']?>
        <?php else: ?>
            <?php $form = ActiveForm::begin([
                'id' => 'import-form',
                'options' => ['enctype' => 'multipart/form-data']
            ]); ?>
                <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'email@example.com']); ?>

                <?= $form->field($model, 'created_df')->textInput(['placeholder' => 'dd.mm.YYYY']); ?>

                <?= $form->field($model, 'file')->fileInput(); ?>

                <div class="form-group">
                    <?= Html::submitButton('Import', ['class' => 'btn btn-primary']); ?>
                </div>
            <?php ActiveForm::end(); ?>
        <?php endif; ?>
        </div>
    </div>
</div>