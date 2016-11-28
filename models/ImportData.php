<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "import_data".
 *
 * @property integer $id
 * @property integer $import_form_id
 * @property string $name
 * @property integer $age
 * @property string $address
 * @property integer $team_id
 *
 * @property ImportForm $importForm
 * @property Team $team
 */
class ImportData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'import_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'import_form_id', 'age', 'team_id'], 'required'],
            [['id', 'import_form_id', 'age', 'team_id'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
            [['import_form_id'], 'exist', 'skipOnError' => true, 'targetClass' => ImportForm::className(), 'targetAttribute' => ['import_form_id' => 'id']],
            [['team_id'], 'exist', 'skipOnError' => true, 'targetClass' => Team::className(), 'targetAttribute' => ['team_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'import_form_id' => 'Import Form ID',
            'name' => 'Name',
            'age' => 'Age',
            'address' => 'Address',
            'team_id' => 'Team ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImportForm()
    {
        return $this->hasOne(ImportForm::className(), ['id' => 'import_form_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeam()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_id']);
    }

    /**
     * @param String $string
     * @param String $search
     * @return String
     */
    function phraseHighlight($string, $search)
    {
        if ($search) {
            return preg_replace('/('.$search.')/i', Html::tag('span', '${1}', [
                'style' => 'background-color: #FFFF00'
            ]), $string);
        }
        return $string;
    }
}
