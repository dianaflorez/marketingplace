<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "planmarketing".
 *
 * @property integer $idpm
 * @property integer $idemp
 * @property string $nombre
 * @property string $descripcion
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Empresa $idemp0
 * @property Usuario $usumod0
 * @property Pmcontenido[] $pmcontenidos
 */
class Planmarketing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'planmarketing';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idemp', 'nombre'], 'required'],
            [['idemp', 'usumod'], 'integer'],
            [['descripcion'], 'string'],
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
            'idpm' => 'Idpm',
            'idemp' => 'Idemp',
            'nombre' => 'Nombre',
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
    public function getUsumod0()
    {
        return $this->hasOne(Usuario::className(), ['idusu' => 'usumod']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPmcontenidos()
    {
        return $this->hasMany(Pmcontenido::className(), ['idpm' => 'idpm']);
    }
}
