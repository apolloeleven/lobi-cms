<?php

namespace backend\models\search;

use intermundia\yiicms\models\CountryTranslation;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use intermundia\yiicms\models\Country;

/**
 * CountrySearch represents the model behind the search form about `intermundia\yiicms\models\Country`.
 */
class CountrySearch extends Country
{
    public $name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['continent_id','id', 'status', 'created_at', 'updated_at', 'deleted_at', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['iso_code_1', 'iso_code_2','name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Country::find()
            ->notDeleted()
            ->joinWith('translations');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'continent_id' => $this->continent_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', CountryTranslation::tableName().'.name', $this->name ]);

        $query->andFilterWhere(['like', 'iso_code_1', $this->iso_code_1])
            ->andFilterWhere(['like', 'iso_code_2', $this->iso_code_2]);

        return $dataProvider;
    }
}
