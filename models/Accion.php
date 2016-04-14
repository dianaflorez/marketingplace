<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accion".
 *
 * @property integer $idaccion
 * @property integer $idpa
 * @property string $descripcion
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Planaccion $idpa0
 * @property Usuario $usumod0
 */
class Accion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpa', 'descripcion'], 'required'],
            [['idpa', 'usumod'], 'integer'],
            [['descripcion'], 'string'],
            [['feccre', 'fecmod'], 'safe'],
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
            'idpa' => 'Idpa',
            'descripcion' => 'Descripcion',
            'feccre' => 'Feccre',
            'fecmod' => 'Fecmod',
            'usumod' => 'Usumod',
        ];
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
