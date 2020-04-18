<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\IngredientForm;
use app\models\Ingredient;

class IngredientController extends Controller
{

    /**
     * Displays ingredient adding page.
     *
     * @return string
     */
    public function actionAdd()
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->username != 'admin') {
            return $this->goHome();
        } else {
            $model = new IngredientForm;
            if ($model->load(Yii::$app->request->post())) {
                $model->create();
                $this->redirect('add');
            }
            $ingredients = Ingredient::find()->all();
            return $this->render('add', compact('model', 'ingredients'));
        }
    }

    /**
     * Displays ingredient editing page.
     *
     * @return string
     */
    public function actionEdit($id)
    {
        if (Yii::$app->user->isGuest || Yii::$app->user->identity->username != 'admin') {
            return $this->goHome();
        } else {
            $model = new IngredientForm;
            if ($model->load(Yii::$app->request->post())) {
                $model->update($id);
                $this->redirect('add');
            }
            $ingredient = Ingredient::findOne($id);
            $model->name = $ingredient->name;
            return $this->render('add', compact('model', 'ingredient'));
        }
    }

}
