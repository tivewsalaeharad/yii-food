<?php

use yii\helpers\Url;

$this->title = 'Главная';
$this->params['breadcrumbs'][] = $this->title;

?>
<h1> Вы зарегистрированы как администратор </h1>
<h3><a href="<?=Url::to(['ingredient/add'])?>">Ингредиенты</a></h3>
<h3><a href="<?=Url::to(['dish/add'])?>">Блюда</a></h3>
