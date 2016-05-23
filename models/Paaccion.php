<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "paaccion".
 *
 * @property integer $idaccion
 * @property integer $idemp
 * @property integer $idpa
 * @property string $descripcion
 * @property integer $orden
 * @property string $fecini
 * @property string $fecfin
 * @property string $responsable
 * @property integer $costo
 * @property string $estado
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Empresa $idemp0
 * @property Planaccion $idpa0
 * @property Usuario $usumod0
 */
class Paaccion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'paaccion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idemp', 'idpa', 'orden', 'costo', 'usumod'], 'integer'],
            [['idpa', 'descripcion'], 'required'],
            [['descripcion', 'responsable'], 'string'],
            [['fecini', 'fecfin', 'feccre', 'fecmod'], 'safe'],
            [['estado'], 'string', 'max' => 25],
            [['idemp'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['idemp' => 'idemp']],
            [['idpa'], 'exist', 'skipOnError' => true, 'targetClass' => Planaccion::className(), 'targetAttribute' => ['idpa' => 'idpa']],
            [['usumod'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usumod' => 'idusu']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idaccion' => 'Idaccion',
            'idemp' => 'Idemp',
            'idpa' => 'Idpa',
            'descripcion' => 'Descripción',
            'orden' => 'Orden',
            'fecini' => 'Fecha de inicio',
            'fecfin' => 'Fecha de finalización',
            'responsable' => 'Responsable',
            'costo' => 'Costo',
            'estado' => 'Estado',
            'feccre' => 'Creacion',
            'fecmod' => 'Modificación',
            'usumod' => 'Quien modificó',
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
    public function getIdpa0()
    {
        return $this->hasOne(Planaccion::className(), ['idpa' => 'idpa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsumod0()
    {
        return $this->hasOne(Usuario::className(), ['idusu' => 'usumod']);
    }
}
