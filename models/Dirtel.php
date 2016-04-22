<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dirtel".
 *
 * @property integer $iddirtel
 * @property integer $idemp
 * @property string $tabla
 * @property integer $idtabla
 * @property integer $idtipo
 * @property string $dirtel
 * @property string $id_pais
 * @property string $id_dep
 * @property string $id_mun
 * @property string $descripcion
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Empresa $idemp0
 * @property Municipio $idPais
 * @property Tipo $idtipo0
 * @property Usuario $usumod0
 */
class Dirtel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dirtel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idemp', 'idtabla', 'idtipo', 'usumod'], 'integer'],
            [['dirtel', 'id_pais', 'id_dep', 'id_mun'], 'required'],
            [['descripcion'], 'string'],
            [['feccre', 'fecmod'], 'safe'],
            [['tabla'], 'string', 'max' => 15],
            [['dirtel'], 'string', 'max' => 50],
            [['id_pais', 'id_dep', 'id_mun'], 'string', 'max' => 3],
            [['idemp'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['idemp' => 'idemp']],
            [['id_pais', 'id_dep', 'id_mun'], 'exist', 'skipOnError' => true, 'targetClass' => Municipio::className(), 'targetAttribute' => ['id_pais' => 'id_pais', 'id_dep' => 'id_dep', 'id_mun' => 'id_mun']],
            [['idtipo'], 'exist', 'skipOnError' => true, 'targetClass' => Tipo::className(), 'targetAttribute' => ['idtipo' => 'idtipo']],
            [['usumod'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usumod' => 'idusu']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iddirtel' => 'Iddirtel',
            'idemp' => 'Idemp',
            'tabla' => 'Tabla',
            'idtabla' => 'Idtabla',
            'idtipo' => 'Idtipo',
            'dirtel' => 'Dirtel',
            'id_pais' => 'Id Pais',
            'id_dep' => 'Id Dep',
            'id_mun' => 'Id Mun',
            'descripcion' => 'Descripcion',
            'feccre' => 'Feccre',
            'fecmod' => 'Fecmod',
            'usumod' => 'Usumod',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdemp0()
    {
        return $this->hasOne(Empresa::className(), ['idemp' => 'idemp']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdPais()
    {
        return $this->hasOne(Municipio::className(), ['id_pais' => 'id_pais', 'id_dep' => 'id_dep', 'id_mun' => 'id_mun']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdtipo0()
    {
        return $this->hasOne(Tipo::className(), ['idtipo' => 'idtipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsumod0()
    {
        return $this->hasOne(Usuario::className(), ['idusu' => 'usumod']);
    }
}
