<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "team".
 *
 * @property integer $id
 * @property string $name
 *
 * @property ImportData[] $importDatas
 */
class Team extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'team';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImportData()
    {
        return $this->hasMany(ImportData::className(), ['team_id' => 'id']);
    }
}
