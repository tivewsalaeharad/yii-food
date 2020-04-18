<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Ingredient;

class IngredientForm extends Model {

    public $id;
    public $name;

    public function rules()
    {
        return [
            ['name', 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Наименование',
        ];
    }

    public function create() {
        if (!$this->validate()) {
            return null;
        }
        $ingredient = new Ingredient;
        $ingredient->name = $this->name;
        return $ingredient->save() ? $ingredient : null;
    }

    public function update($id) {
        if (!$this->validate()) {
            return null;
        }
        $ingredient = Ingredient::findOne($id);
        $ingredient->name = $this->name;
        return $ingredient->save() ? $ingredient : null;
    }

}

?>
