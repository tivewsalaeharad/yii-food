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

    static public function getAllMatches(array $ingredients)
    {
        $query = (new Query)
            ->select([
                'dish.id',
                'dish.name',
                'COUNT(CASE WHEN consist.ingredient_id NOT IN ('.implode(', ', $ingredients).') OR consist.hidden = 1 THEN 1 ELSE NULL END) AS dismatch',
                'COUNT(*) as matches'
            ])
            ->from('dish')
            ->innerJoin('consist', 'dish.id = consist.dish_id')
            ->groupBy('dish.id')
            ->having('dismatch = 0')
            ->andHaving('matches = '.count($ingredients));
        return $query->all();
    }

    static public function getPartialMatches(array $ingredients)
    {
        $query = (new Query)
            ->select([
                'dish.id',
                'dish.name',
                'COUNT(CASE WHEN consist.ingredient_id IN ('.implode(', ', $ingredients).') THEN 1 ELSE NULL END) AS matches',
                'COUNT(CASE WHEN consist.hidden = 1 THEN 1 ELSE NULL END) as dismatch'
            ])
            ->from('dish')
            ->innerJoin('consist', 'dish.id = consist.dish_id')
            ->groupBy('dish.id')
            ->having('dismatch = 0')
            ->andHaving('matches > 1')
            ->orderBy('matches DESC');
        return $query->all();
    }

    public function getPresent()
    {
        $present_query = (new Query)
            ->select('ingredient.*')
            ->from('ingredient')
            ->innerJoin('consist', 'ingredient.id = consist.ingredient_id')
            ->where('dish_id = :dishid', [':dishid' => $this->id])
            ->groupBy('ingredient.id');
        return $present_query->all();
    }
    
    public function getHidden()
    {
        $hidden_query = (new Query)
            ->select('ingredient.id')
            ->from('ingredient')
            ->innerJoin('consist', 'ingredient.id = consist.ingredient_id')
            ->where('dish_id = :dishid', [':dishid' => $this->id])
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
            ->having('COUNT(CASE WHEN dish_id = :dishid THEN 1 ELSE NULL END) = 0', [':dishid' => $this->id]);
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
