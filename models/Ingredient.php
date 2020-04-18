<?php
 
namespace app\models;
 
use Yii;
use yii\db\ActiveRecord;

class Ingredient extends ActiveRecord
{
    
    public static function tableName()
    {
        return 'ingredient';
    }

    static public function getArrayForCheckboxList()
    {
         array_walk(Ingredient::find()->all(), function($value) use(&$result) {
             $result[$value->id] = $value->name;
         });
         return $result;
    }

}
