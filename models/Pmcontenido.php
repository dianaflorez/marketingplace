<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pmcontenido".
 *
 * @property integer $idpmc
 * @property integer $idpm
 * @property string $titulo
 * @property string $descripcion
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Planmarketing $idpm0
 * @property Usuario $usumod0
 */
class Pmcontenido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pmcontenido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idpm'], 'required'],
            [['idpm', 'usumod'], 'integer'],
            [['descripcion'], 'string'],
            [['feccre', 'fecmod'], 'safe'],
            [['titulo'], 'string', 'max' => 30],
            [['idpm'], 'exist', 'skipOnError' => true, 'targetClass' => Planmarketing::className(), 'targetAttribute' => ['idpm' => 'idpm']],
            [['usumod'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usumod' => 'idusu']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idpmc' => 'Idpmc',
            'idpm' => 'Idpm',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'feccre' => 'Feccre',
            'fecmod' => 'Fecmod',
            'usumod' => 'Usumod',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdpm0()
    {
        return $this->hasOne(Planmarketing::className(), ['idpm' => 'idpm']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsumod0()
    {
        return $this->hasOne(Usuario::className(), ['idusu' => 'usumod']);
    }
}
