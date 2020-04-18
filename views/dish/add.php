<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\DishForm */
/* @var $dish app\models\Dish */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = isset($dish) ? 'Редактировать блюдо' : 'Новое блюдо';
$this->params['breadcrumbs'][] = $this->title;
$btn_caption = isset($dish) ? 'Сохранить' : 'Добавить';
?>

<h1><?= Html::encode($this->title) ?></h1>
<?php $form = ActiveForm::begin(['id' => 'form-new-ingredient']); ?>
    <?=$form->field($model, 'name')->textInput(['autofocus' => true]) ?>
    <?php if (isset($dishes)) : ?>
        <?=$form->field($model, 'ingredients')->inline(true)->checkboxList($ingredients)?>
    <?php elseif (isset($dish)) : ?>
        <?=$ingredients['absent'] ? $form->field($model, 'toadd')->inline(true)->checkboxList($ingredients['absent']) : ''?>
        <?=$ingredients['present'] ? $form->field($model, 'tohide')->inline(true)->checkboxList($ingredients['present']) : ''?>
        <?=$ingredients['present'] ? $form->field($model, 'toremove')->inline(true)->checkboxList($ingredients['present']) : ''?>
    <?php endif; ?>
    <div class="form-group">
        <?= Html::submitButton($btn_caption, ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>
<?php ActiveForm::end(); ?>
<?php if (isset($dishes)) :?>
    <h2> Добавленные блюда </h2>
    <?php foreach ($dishes as $dish) :?>
        <a href="<?=Url::to(['dish/edit', 'id' => $dish->id])?>"><?=$dish->name?></a>
    <?php endforeach;?>
<?php endif; ?>
