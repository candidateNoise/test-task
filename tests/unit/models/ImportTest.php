<?php

namespace tests\models;

use app\models\ImportForm;
use app\models\ImportData;
use app\models\Team;

class ImportTest extends \Codeception\Test\Unit
{
    public function testDataImport()
    {
        $importFormModel = new ImportForm();

        // Test email attribute
        $importFormModel->email = NULL;
        $this->assertFalse($importFormModel->validate(['email']));

        $importFormModel->email = 'tester.email';
        $this->assertFalse($importFormModel->validate(['email']));

        $importFormModel->email = 'tester@pipedrive.lc';
        $this->assertTrue($importFormModel->validate(['email']));

        // Test created_df attribute
        $importFormModel->created_df = NULL;
        $this->assertFalse($importFormModel->validate(['created_df']));

        $importFormModel->created_df = 'tester.created_df';
        $this->assertFalse($importFormModel->validate(['created_df']));

        $importFormModel->created_df = '28.11.2016';
        $this->assertTrue($importFormModel->validate(['created_df']));

        // Test file attribute
        $importFormModel->file = NULL;
        $this->assertFalse($importFormModel->validate(['file']));

        // Test save
        $importFormModel->file = (object)[
            'name' => 'import.csv',
            'tempName' => codecept_data_dir('import.csv'),
            'type' => 'text/csv',
            'size' => filesize(codecept_data_dir('import.csv')),
            'error' => 0
        ];
        $this->assertTrue($importFormModel->save());
    }

    public function testDatabase()
    {
        $importFormModel = new ImportForm();
            $importFormModel->email = 'tester@pipedrive.lc';
            $importFormModel->created_df = '28.11.2016';
            $importFormModel->file = (object)[
                'name' => 'import.csv',
                'tempName' => codecept_data_dir('import.csv'),
                'type' => 'text/csv',
                'size' => filesize(codecept_data_dir('import.csv')),
                'error' => 0
            ];
        $importFormModel->save();
        $importId = $importFormModel;

        $importFormModel = ImportForm::find()->all();
        $this->assertEquals(1, count($importFormModel));

        $importDataModel = ImportData::find()->all();
        $this->assertEquals(5, count($importDataModel));

        $teamModel = Team::find()->all();
        $this->assertEquals(4, count($teamModel));

        Team::findOne([
            'name' => 'WHITE'
        ])->delete();

        $teamModel = Team::find()->all();
        $this->assertEquals(3, count($teamModel));

        $importDataModel = ImportData::find()->all();
        $this->assertEquals(4, count($importDataModel));

        ImportForm::findOne([
            'id' => $importId
        ])->delete();

        $importDataModel = ImportData::find()->all();
        $this->assertEquals(0, count($importDataModel));
    }
}
