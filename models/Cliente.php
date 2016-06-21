<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cliente".
 *
 * @property integer $idcli
 * @property string $nit
 * @property string $nombre1
 * @property string $nombre2
 * @property string $apellido1
 * @property string $apellido2
 * @property integer $idtide
 * @property string $identificacion
 * @property string $fecnac
 * @property string $genero
 * @property string $tipo
 * @property string $estado
 * @property string $observacion
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Cita[] $citas
 * @property Tipo $idtide0
 * @property Usuario $usumod0
 */
class Cliente extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cliente';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtide', 'usumod'], 'integer'],
            [['fecnac', 'feccre', 'fecmod'], 'safe'],
            [['observacion'], 'string'],
            [['nit', 'nombre1'], 'string', 'max' => 40],
            [['nombre2', 'apellido1', 'apellido2'], 'string', 'max' => 30],
            [['identificacion'], 'string', 'max' => 20],
            [['genero'], 'string', 'max' => 9],
            [['tipo'], 'string', 'max' => 13],
            [['email'], 'string', 'max' => 90],
            // the email attribute should be a valid email address
            ['email', 'email'],
            [['estado'], 'string', 'max' => 9],
            [['idtide'], 'exist', 'skipOnError' => true, 'targetClass' => Tipo::className(), 'targetAttribute' => ['idtide' => 'idtipo']],
            [['usumod'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usumod' => 'idusu']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcli' => 'Idcli',
            'nit' => 'Nit',
            'nombre1' => 'Nombre',
            'nombre2' => 'Nombre2',
            'apellido1' => 'Apellido',
            'apellido2' => 'Apellido2',
            'idtide' => 'Tipo Identificación',
            'identificacion' => 'Número',
            'fecnac' => 'Fecha Nacimiento',
            'genero' => 'Género',
            'tipo' => 'Tipo',
            'estado' => 'Estado',
            'email' => 'Email',
            'observacion' => 'Observación',
            'feccre' => 'Creacion',
            'fecmod' => 'Modificado',
            'usumod' => 'Quien Modifico',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitas()
    {
        return $this->hasMany(Cita::className(), ['idcli' => 'idcli']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdtide0()
    {
        return $this->hasOne(Tipo::className(), ['idtipo' => 'idtide']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsumod0()
    {
        return $this->hasOne(Usuario::className(), ['idusu' => 'usumod']);
    }
}
