<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Ingredient;
use app\models\Dish;
use app\models\Consist;

class DishSearchForm extends Model
{

    public $ingredients;

    public function attributeLabels()
    {
        return [
            'ingredients' => 'Выберите ингредиенты для поиска',
        ];
    }


    public function rules()
    {
        return [
            [['ingredients'], 'safe'],
        ];
    }

}
