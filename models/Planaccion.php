<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "planaccion".
 *
 * @property integer $idpa
 * @property integer $idemp
 * @property string $nombre
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Paaccion[] $paaccions
 * @property Paaelemento[] $paaelementos
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
            [['idemp', 'usumod'], 'integer'],
            [['feccre', 'fecmod'], 'safe'],
            [['nombre'], 'string', 'max' => 30],
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
            'feccre' => 'Feccre',
            'fecmod' => 'Fecmod',
            'usumod' => 'Usumod',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaaccions()
    {
        return $this->hasMany(Paaccion::className(), ['idpa' => 'idpa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaaelementos()
    {
        return $this->hasMany(Paaelemento::className(), ['idpa' => 'idpa']);
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
