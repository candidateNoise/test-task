<?php

class ImportFormCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnPage(['site/import']);
    }

    public function openImportPage(\FunctionalTester $I)
    {
        $I->see('Import', 'h1');
    }

    public function submitEmptyForm(\FunctionalTester $I)
    {
        $I->submitForm('#import-form', []);

        $I->expectTo('see validations errors');
        $I->see('Import', 'h1');
        $I->see('Email cannot be blank');
        $I->see('Created cannot be blank');
        $I->see('File cannot be blank');
    }

    public function submitFormWithIncorrectEmail(\FunctionalTester $I)
    {
        $I->attachFile('input[type=file]',  'import.csv');
        $I->submitForm('#import-form', [
            'ImportForm[email]' => 'tester.email',
            'ImportForm[created_df]' => '28.11.2016',
        ]);

        $I->expectTo('see that email address is wrong');
        $I->see('Email is not a valid email address.');
        $I->dontSee('Created cannot be blank.', '.help-block');
        $I->dontSee('File cannot be blank', '.help-block');
    }

    public function submitFormWithIncorrectCreated(\FunctionalTester $I)
    {
        $I->attachFile('input[type=file]',  'import.csv');
        $I->submitForm('#import-form', [
            'ImportForm[email]' => 'tester@pipedrive.lc',
            'ImportForm[created_df]' => 'tester.created_df',
        ]);

        $I->expectTo('see that created date is wrong');
        $I->dontSee('Email cannot be blank', '.help-block');
        $I->see('The format of Created is invalid.');
        $I->dontSee('File cannot be blank', '.help-block');
    }

    public function submitFormSuccessfully(\FunctionalTester $I)
    {
        $I->attachFile('input[type=file]',  'import.csv');
        $I->submitForm('#import-form', [
            'ImportForm[email]' => 'tester@pipedrive.lc',
            'ImportForm[created_df]' => '28.11.2016',
        ]);

        $I->seeEmailIsSent();
        $I->see('Import completed');
    }
}
