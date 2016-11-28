<?php

use yii\db\Migration;

/**
 * Handles the creation of table `import_data`.
 */
class m161125_093100_create_import_data_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%import_data}}', [
            'id' => $this->integer(11)->unsigned()->notNull(),
            'import_form_id' => $this->integer(11)->unsigned()->notNull(),
            'name' => $this->string(255),
            'age' => $this->smallInteger(3)->unsigned()->notNull(),
            'address' => $this->string(255),
            'team_id' => $this->integer(11)->unsigned()->notNull()
        ]);

        $this->addPrimaryKey('PK', '{{%import_data}}', ['id', 'import_form_id']);

        $this->addForeignKey('fk_import_data_import_form_id', '{{%import_data}}', 'import_form_id', '{{%import_form}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_import_data_team_id', '{{%import_data}}', 'team_id', '{{%team}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%import_data}}');
    }
}
