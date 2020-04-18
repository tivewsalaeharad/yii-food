<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\DishSearchForm */

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;

$this->title = 'Главная';
$this->params['breadcrumbs'][] = $this->title;
?>
<h1> Вы зарегистрированы как пользователь </h1>

<?php
Pjax::begin();
    $form = ActiveForm::begin([
        'options' => ['data' => ['pjax' => true]]
    ]);
    if ($ingredients) {
        echo $form->field($model, 'ingredients')->inline(true)->checkboxList($ingredients);
    }
    ?>
    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
    </div>
    <?

    if ($msg) echo "<h3>$msg</h3>";

    if ($dishes) {
        foreach($dishes as $dish) {
            echo "<p>{$dish['name']}, совпадений: {$dish['matches']}</p>";
        }
    }
    
    ActiveForm::end();
Pjax::end();

