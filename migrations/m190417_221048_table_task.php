<?php

use yii\db\Migration;

/**
 * Class m190417_221048_table_task
 */
class m190417_221048_table_task extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$this->createTable('task', [
			'id' => $this->primaryKey(),
			'title' => $this->string()->notNull(),
			'description' => $this->text()->notNull(),
			'creator_id' => $this->integer()->notNull(),
			'updater_id' => $this->integer(),
			'created_at' => $this->integer()->notNull(),
			'updated_at' => $this->integer(),
		]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190417_221048_table_task cannot be reverted.\n";

		$this->dropTable('task');
        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190417_221048_table_task cannot be reverted.\n";

        return false;
    }
    */
}
