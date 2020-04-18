<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m200417_153806_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('ingredient', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
        ]);

        $this->createTable('dish', [
            'id' => $this->primaryKey(),
            'name' => $this->string()
        ]);

        $this->createTable('consist', [
            'id' => $this->primaryKey(),
            'dish_id' => $this->integer(),
            'ingredient_id' => $this->integer(),
            'hidden' => $this->boolean(),
        ]);

        $this->addForeignKey('dish_consist', 'consist', 'dish_id', 'dish', 'id');
        $this->addForeignKey('consist_of_ingredient', 'consist', 'ingredient_id', 'ingredient', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('dish_consist', 'consist');
        $this->dropForeignKey('consist_of_ingredient', 'consist');
        
        $this->dropTable('ingredient');
        $this->dropTable('dish');
        $this->dropTable('consist');
    }
}
