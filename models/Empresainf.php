<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empresainf".
 *
 * @property integer $idinf
 * @property integer $idemp
 * @property integer $idtipo
 * @property string $inf
 * @property string $descripcion
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Empresa $idemp0
 * @property Usuario $usumod0
 */
class Empresainf extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresainf';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idemp', 'idtipo', 'inf'], 'required'],
            [['idemp', 'idtipo', 'usumod'], 'integer'],
            [['inf', 'descripcion'], 'string'],
            [['feccre', 'fecmod'], 'safe'],
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
            'idinf' => 'Idinf',
            'idemp' => 'Empresa',
            'idtipo' => 'Tipo',
            'inf' => 'Informacion',
            'descripcion' => 'Descripcion',
            'feccre' => 'Creacion',
            'fecmod' => 'Modificacion',
            'usumod' => 'Modifico',
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
}
