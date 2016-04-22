<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "departamento".
 *
 * @property string $id_dep
 * @property string $id_pais
 * @property string $nombre
 *
 * @property Pais $idPais
 * @property Municipio[] $municipios
 */
class Departamento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'departamento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_dep', 'id_pais', 'nombre'], 'required'],
            [['id_dep', 'id_pais'], 'string', 'max' => 3],
            [['nombre'], 'string', 'max' => 30],
            [['id_pais'], 'exist', 'skipOnError' => true, 'targetClass' => Pais::className(), 'targetAttribute' => ['id_pais' => 'id_pais']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_dep' => 'Id Dep',
            'id_pais' => 'Id Pais',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPais()
    {
        return $this->hasOne(Pais::className(), ['id_pais' => 'id_pais']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMunicipios()
    {
        return $this->hasMany(Municipio::className(), ['id_pais' => 'id_pais', 'id_dep' => 'id_dep']);
    }
}
