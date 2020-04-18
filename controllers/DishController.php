<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Ingredient;
use app\models\DishForm;
use app\models\Dish;

class DishController extends Controller
{

    /**
     * Displays dish adding page.
     *
     * @return string
     */
    public function actionAdd()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->username != 'admin') {
            return $this->goHome();
        } else {
            $model = new DishForm;
            
            if ($model->load(Yii::$app->request->post())) {
                $model->create();
                $this->redirect('add');
            }

            $ingredients = Ingredient::getArrayForCheckboxList();
            $dishes = Dish::find()->all();
            return $this->render('add', compact('model', 'ingredients', 'dishes'));
        }
    }

    /**
     * Displays dish editing page.
     *
     * @return string
     */
    public function actionEdit($id)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->username != 'admin') {
            return $this->goHome();
        } else {
            $model = new DishForm;
            
            if ($model->load(Yii::$app->request->post())) {
                $model->update($id);
                $this->redirect('add');
            }
            
            $dish = Dish::findOne($id);
            $model->name = $dish->name;
            $ingredients = $dish->getArraysForCheckboxList();
            $model->tohide = $ingredients['hidden'];
            return $this->render('add', compact('model', 'dish', 'ingredients'));
        }
    }

}
