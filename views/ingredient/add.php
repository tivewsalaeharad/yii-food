<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\IngredientForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

$this->title = isset($ingredient) ? 'Редактировать ингредиент' : 'Новый ингредиент';
$this->params['breadcrumbs'][] = $this->title;
$btn_caption = isset($ingredient) ? 'Сохранить' : 'Добавить'; 
?>
<h1><?= Html::encode($this->title) ?></h1>
<?php $form = ActiveForm::begin(['id' => 'form-new-ingredient']); ?>
    <?=$form->field($model, 'name')->textInput(['autofocus' => true]) ?>
    <div class="form-group">
        <?=Html::submitButton($btn_caption, ['class' => 'btn btn-primary', 'name' => 'signup-button'])?>
    </div>
<?php ActiveForm::end(); ?>
<?php if (isset($ingredients)) :?>
    <h2> Добавленные ингредиенты </h2>
    <?php foreach ($ingredients as $ingredient) :?>
        <a href="<?=Url::to(['ingredient/edit', 'id' => $ingredient->id])?>"><?=$ingredient->name?></a>
    <?php endforeach;?>
<?php endif; ?>
