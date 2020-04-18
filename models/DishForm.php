<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Ingredient;
use app\models\Dish;
use app\models\Consist;

class DishForm extends Model {

    public $name;
    public $ingredients;
    public $toadd;
    public $tohide;
    public $toremove;

    public function rules()
    {
        return [
            ['name', 'required'],
            [['ingredients', 'toadd', 'tohide', 'toremove'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Наименование',
            'ingredients' => 'Ингредиенты',
            'toadd' => 'Добавить ингредиенты',
            'tohide' => 'Скрыть ингредиенты',
            'toremove' => 'Удалить ингредиенты'
        ];
    }

    public function create()
    {
        if (!$this->validate()) {
            return null;
        }
        $dish = new Dish;
        $dish->name = $this->name;
        if (!$dish->save()) return null;
        $dish->refresh();

        if ($this->ingredients) {
            foreach ($this->ingredients as $ingredient) {
                $consist = new Consist;
                $consist->ingredient_id = $ingredient;
                $consist->dish_id = $dish->id;
                $consist->save();
            }
        }
        return $dish;
    }

    public function update($id)
    {

        if (!$this->validate()) {
            return null;
        }
        $dish = Dish::findOne($id);
        $dish->name = $this->name;
        if (!$dish->save()) return null;

        if ($this->toadd) {
            foreach ($this->toadd as $ingredient) {
                $consist = new Consist;
                $consist->ingredient_id = $ingredient;
                $consist->dish_id = $id;
                $consist->save();
            }
        }

        if ($this->tohide) {
            foreach ($dish->getPresent() as $ingredient) {
                $consist = Consist::findOne(['ingredient_id' => $ingredient, 'dish_id' => $id]);
                $consist->hidden = in_array($ingredient['id'], $this->tohide) ? 1 : NULL;
                $consist->save();
            }
        }

        if ($this->toremove) {
            foreach ($this->toremove as $ingredient) {
                $consist = Consist::findOne(['ingredient_id' => $ingredient, 'dish_id' => $id]);
                $consist->delete();
            }
        }

        return $dish;

    }

}

?>
