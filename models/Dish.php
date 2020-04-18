<?php
 
namespace app\models;
 
use Yii;
use yii\db\ActiveRecord;
use yii\db\Query;

class Dish extends ActiveRecord
{
    
    static public function tableName()
    {
        return 'dish';
    }

    public function getPresent()
    {
        $present_query = (new Query)
            ->select('ingredient.*')
            ->from('ingredient')
            ->innerJoin('consist', 'ingredient.id = consist.ingredient_id')
            ->where("dish_id = $this->id")
            ->groupBy('ingredient.id');
        return $present_query->all();
    }
    
    public function getHidden()
    {
        $hidden_query = (new Query)
            ->select('ingredient.id')
            ->from('ingredient')
            ->innerJoin('consist', 'ingredient.id = consist.ingredient_id')
            ->where("dish_id = $this->id")
            ->andWhere("hidden = 1")
            ->groupBy('ingredient.id');
        return $hidden_query->all();
    }
    
    public function getAbsent()
    {
        $absent_query = (new Query)
            ->select('ingredient.*')
            ->from('ingredient')
            ->leftJoin('consist', 'ingredient.id = consist.ingredient_id')
            ->groupBy('ingredient.id')
            ->having("COUNT(CASE WHEN dish_id = $this->id THEN 1 ELSE NULL END) = 0");
        return $absent_query->all();
    }
    
    public function getArraysForCheckBoxList()
    {
        array_walk($this->getPresent(), function($value) use(&$present) {
            $present[$value['id']] = $value['name'];
        });

        array_walk($this->getHidden(), function($value) use(&$hidden) {
            $hidden[] = $value['id'];
        });

        array_walk($this->getAbsent(), function($value) use(&$absent) {
            $absent[$value['id']] = $value['name'];
        });

        return compact('present', 'hidden', 'absent');
    }

}
