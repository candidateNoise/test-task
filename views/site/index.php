<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Test task solution';

?>

<div>
    <h1><?= Html::encode($this->title) ?></h1>

    Go to <a href="<?= Url::to(['site/import']); ?>">import page</a> or <a href="<?= Url::to(['site/search']) ?>">view imported</a>
</div>