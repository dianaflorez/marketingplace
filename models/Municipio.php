<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "municipio".
 *
 * @property string $id_pais
 * @property string $id_dep
 * @property string $id_mun
 * @property string $nombre
 *
 * @property Dirtel[] $dirtels
 * @property Departamento $idPais
 */
class Municipio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'municipio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pais', 'id_dep', 'id_mun', 'nombre'], 'required'],
            [['id_pais', 'id_dep', 'id_mun'], 'string', 'max' => 3],
            [['nombre'], 'string', 'max' => 40],
            [['id_pais', 'id_dep'], 'exist', 'skipOnError' => true, 'targetClass' => Departamento::className(), 'targetAttribute' => ['id_pais' => 'id_pais', 'id_dep' => 'id_dep']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pais' => 'Id Pais',
            'id_dep' => 'Id Dep',
            'id_mun' => 'Id Mun',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDirtels()
    {
        return $this->hasMany(Dirtel::className(), ['id_pais' => 'id_pais', 'id_dep' => 'id_dep', 'id_mun' => 'id_mun']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPais()
    {
        return $this->hasOne(Departamento::className(), ['id_pais' => 'id_pais', 'id_dep' => 'id_dep']);
    }
}
