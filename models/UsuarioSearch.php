<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Usuario;

/**
 * UsuarioSearch represents the model behind the search form about `app\models\Usuario`.
 */
class UsuarioSearch extends Usuario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idusu', 'idtide', 'role', 'activo', 'idemp', 'usumod'], 'integer'],
            [['nombre1', 'nombre2', 'apellido1', 'apellido2', 'identificacion', 'login', 'clave', 'authkey', 'accesstoken', 'estado', 'feccre', 'fecmod'], 'safe'],
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
        $query = Usuario::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idusu' => $this->idusu,
            'idtide' => $this->idtide,
            'role' => $this->role,
            'activo' => $this->activo,
            'idemp' => $this->idemp,
            'feccre' => $this->feccre,
            'fecmod' => $this->fecmod,
            'usumod' => $this->usumod,
        ]);

        $query->andFilterWhere(['like', 'nombre1', $this->nombre1])
            ->andFilterWhere(['like', 'nombre2', $this->nombre2])
            ->andFilterWhere(['like', 'apellido1', $this->apellido1])
            ->andFilterWhere(['like', 'apellido2', $this->apellido2])
            ->andFilterWhere(['like', 'identificacion', $this->identificacion])
            ->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'clave', $this->clave])
            ->andFilterWhere(['like', 'authkey', $this->authkey])
            ->andFilterWhere(['like', 'accesstoken', $this->accesstoken])
            ->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
}
