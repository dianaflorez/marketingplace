<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pais".
 *
 * @property string $id_pais
 * @property string $nombre
 *
 * @property Departamento[] $departamentos
 */
class Pais extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pais';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_pais', 'nombre'], 'required'],
            [['id_pais'], 'string', 'max' => 3],
            [['nombre'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_pais' => 'Id Pais',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartamentos()
    {
        return $this->hasMany(Departamento::className(), ['id_pais' => 'id_pais']);
    }
}
