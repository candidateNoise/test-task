<?php

use yii\db\Migration;

/**
 * Handles the creation of table `team`.
 */
class m161125_092938_create_team_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('team', [
            'id' => $this->primaryKey(11)->unsigned()->notNull(),
            'name' => $this->string(255)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('team');
    }
}
