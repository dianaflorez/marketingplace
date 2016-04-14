<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "planaccion".
 *
 * @property integer $idpa
 * @property integer $idemp
 * @property string $nombre
 * @property string $fecini
 * @property string $fecfin
 * @property string $responsable
 * @property integer $costo
 * @property string $estado
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Accion[] $accions
 * @property Elemento[] $elementos
 * @property Empresa $idemp0
 * @property Usuario $usumod0
 */
class Planaccion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'planaccion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idemp', 'nombre'], 'required'],
            [['idemp', 'costo', 'usumod'], 'integer'],
            [['fecini', 'fecfin', 'feccre', 'fecmod'], 'safe'],
            [['responsable'], 'string'],
            [['nombre'], 'string', 'max' => 30],
            [['estado'], 'string', 'max' => 25],
            [['idemp'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['idemp' => 'idemp']],
            [['usumod'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usumod' => 'idusu']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpa' => 'Idpa',
            'idemp' => 'Idemp',
            'nombre' => 'Nombre',
            'fecini' => 'Fecini',
            'fecfin' => 'Fecfin',
            'responsable' => 'Responsable',
            'costo' => 'Costo',
            'estado' => 'Estado',
            'feccre' => 'Feccre',
            'fecmod' => 'Fecmod',
            'usumod' => 'Usumod',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccions()
    {
        return $this->hasMany(Accion::className(), ['idpa' => 'idpa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElementos()
    {
        return $this->hasMany(Elemento::className(), ['idpa' => 'idpa']);
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
    public function getUsumod0()
    {
        return $this->hasOne(Usuario::className(), ['idusu' => 'usumod']);
    }
}
