<?php

namespace app\models;

use Yii;
use app\models\Team;
use app\models\ImportData;

/**
 * This is the model class for table "import_form".
 *
 * @property integer $id
 * @property string $email
 * @property string $created
 */
class ImportForm extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile|Null file attribute
     */
    public $file;

    /**
     * @var String created_df attribute
     */
    public $created_df;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'import_form';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'created_df', 'file'], 'required'],
            [['email'], 'email'],
            [['created_df'], 'date', 'format' => 'php:d.m.Y'],
            [['file'], 'file']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'created' => 'Created',
            'created_df' => 'Created'
        ];
    }

    public function save($runValidation = FALSE, $attributeNames = NULL)
    {
        $startTime = microtime(TRUE);

        $this->created = Yii::$app->formatter->asDate($this->created_df, 'php:Y-m-d');

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $teams = [];

            $isSave = parent::save($runValidation, $attributeNames);

            if ($isSave) {
                $importFile = file($this->file->tempName);
                $rowsToSave = [];
                foreach ((array)$importFile AS $key => $_record) {
                    $record = str_getcsv($_record, ',', '"');

                    if (!isset($teams[$record[4]])) {
                        $team = Team::find()->where([
                            'name' => $record[4]
                        ])->one();

                        if ($team === NULL) {
                            $team = new Team([
                                'name' => $record[4]
                            ]);
                            $team->insert();
                        }
                        $teams[$record[4]] = $team->id;
                    }
                    $teamId = $teams[$record[4]];

                    $rowsToSave[] = [
                        $record[0], $this->id, $record[1], (int)$record[2], $record[3], $teamId
                    ];
                    if (count($rowsToSave) >= 2000) {
                        $isSave = $this->_batchInsert($rowsToSave);
                        $rowsToSave = [];
                    }
                }

                $isSave = $this->_batchInsert($rowsToSave);

                if ($isSave) {
                    $transaction->commit();

                    $elapsedTime = (microtime(TRUE) - $startTime);

                    $emailBody = "Hello!\n\n"
                        ."Data imported successfully.\n\n"
                        ."Impot time: ".number_format($elapsedTime, 3, '.', ' ')." secods.\n"
                        ."Record imported: ".count($importFile);

                    Yii::$app->mailer->compose()
                        ->setTo($this->email)
                        ->setFrom([Yii::$app->params['adminEmail'] => 'Data Import'])
                        ->setSubject('Import report')
                        ->setTextBody($emailBody)
                        ->send();

                    return TRUE;
                }
            }
        } catch (Exception $e) {
            Yii::error($e->getMessage());
        }

        $transaction->rollBack();
    }

    protected function _batchInsert($rowsToSave)
    {
        return Yii::$app->db->createCommand()->batchInsert(ImportData::tableName(), [
            'id',
            'import_form_id',
            'name',
            'age',
            'address',
            'team_id'
        ], $rowsToSave)->execute();
    }
}
