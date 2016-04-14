<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "elemento".
 *
 * @property integer $idele
 * @property integer $idemp
 * @property integer $idpa
 * @property string $descripcion
 * @property integer $orden
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Empresa $idemp0
 * @property Planaccion $idpa0
 * @property Usuario $usumod0
 */
class Elemento extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'elemento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idemp', 'idpa', 'orden', 'usumod'], 'integer'],
            [['descripcion'], 'string'],
            [['feccre', 'fecmod'], 'safe'],
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
            'idele' => 'Idele',
            'idemp' => 'Idemp',
            'idpa' => 'Idpa',
            'descripcion' => 'Descripcion',
            'orden' => 'Orden',
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
