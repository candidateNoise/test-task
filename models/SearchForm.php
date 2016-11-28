<?php

namespace app\models;

use yii\base\Model;

/**
 * This is the model class for search form.
 *
 * @property integer $id
 * @property string $email
 * @property string $created
 */
class SearchForm extends Model
{
    /**
     * @var String search_phrase attribute
     */
    public $search_phrase;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['search_phrase'], 'string', 'length' => [3]],
            [['search_phrase'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'search_phrase' => 'Search Phrase'
        ];
    }
}
