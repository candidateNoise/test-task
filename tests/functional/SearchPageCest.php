<?php

class SearchPageCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnPage(['site/search']);
    }

    public function openImportPage(\FunctionalTester $I)
    {
        $I->see('Search', 'h1');
    }

    public function submitEmptyForm(\FunctionalTester $I)
    {
        $I->submitForm('#search-form', []);

        $I->expectTo('see validations errors');
        $I->see('Search', 'h1');
        $I->see('Search Phrase cannot be blank');
    }

    public function submitFormWithIncorrectSearchPhrase(\FunctionalTester $I)
    {
        $I->submitForm('#search-form', [
            'SearchForm[search_phrase]' => 'te'
        ]);

        $I->expectTo('see validations errors');
        $I->see('Search Phrase should contain at least 3 characters.');
    }
}
