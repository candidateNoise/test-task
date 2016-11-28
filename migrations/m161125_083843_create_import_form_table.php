<?php

use yii\db\Migration;

/**
 * Handles the creation of table `import_form`.
 */
class m161125_083843_create_import_form_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%import_form}}', [
            'id' => $this->primaryKey(11)->unsigned()->notNull(),
            'email' => $this->string(255)->notNull()->defaultValue(''),
            'created' => $this->date()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%import_form}}');
    }
}
