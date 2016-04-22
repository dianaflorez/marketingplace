<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cita".
 *
 * @property integer $idcita
 * @property integer $idemp
 * @property integer $idusu
 * @property integer $idcli
 * @property string $fecha
 * @property string $hora
 * @property string $estado
 * @property string $observacion
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Cliente $idcli0
 * @property Empresa $idemp0
 * @property Usuario $idusu0
 * @property Usuario $usumod0
 * @property Citapedido $citapedido
 */
class Cita extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cita';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idemp', 'idusu', 'idcli', 'observacion'], 'required'],
            [['idemp', 'idusu', 'idcli', 'usumod'], 'integer'],
            [['fecha', 'hora', 'feccre', 'fecmod'], 'safe'],
            [['observacion'], 'string'],
            [['estado'], 'string', 'max' => 12],
            [['idcli'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::className(), 'targetAttribute' => ['idcli' => 'idcli']],
            [['idemp'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['idemp' => 'idemp']],
            [['idusu'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idusu' => 'idusu']],
            [['usumod'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usumod' => 'idusu']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcita' => 'Idcita',
            'idemp' => 'Idemp',
            'idusu' => 'Idusu',
            'idcli' => 'Idcli',
            'fecha' => 'Fecha',
            'hora' => 'Hora',
            'estado' => 'Estado',
            'observacion' => 'Observacion',
            'feccre' => 'Feccre',
            'fecmod' => 'Fecmod',
            'usumod' => 'Usumod',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcli0()
    {
        return $this->hasOne(Cliente::className(), ['idcli' => 'idcli']);
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
    public function getIdusu0()
    {
        return $this->hasOne(Usuario::className(), ['idusu' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsumod0()
    {
        return $this->hasOne(Usuario::className(), ['idusu' => 'usumod']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitapedido()
    {
        return $this->hasOne(Citapedido::className(), ['idcita' => 'idcita']);
    }
}
