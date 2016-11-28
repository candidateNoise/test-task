<?php

$config = [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=pipedrive',
    'username' => 'user',
    'password' => 'password',
    'charset' => 'utf8',
];

$localConfigFile = dirname(__FILE__) . "/" . basename(__FILE__, ".php") . "-local.php";
$localConfig = [];
if (file_exists($localConfigFile)) {
    $localConfig = require($localConfigFile);
}

return \yii\helpers\ArrayHelper::merge($config, $localConfig);