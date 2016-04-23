<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "citapedido".
 *
 * @property integer $idpedido
 * @property integer $idemp
 * @property integer $idcita
 * @property string $pedido
 * @property integer $cant
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Cita $idcita0
 * @property Empresa $idemp0
 * @property Usuario $usumod0
 */
class Citapedido extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'citapedido';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idemp', 'idcita', 'cant', 'usumod'], 'integer'],
            [['pedido'], 'required'],
            [['pedido'], 'string'],
            [['feccre', 'fecmod'], 'safe'],
            [['idcita'], 'exist', 'skipOnError' => true, 'targetClass' => Cita::className(), 'targetAttribute' => ['idcita' => 'idcita']],
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
            'idpedido' => 'Idpedido',
            'idemp' => 'Idemp',
            'idcita' => 'Idcita',
            'pedido' => 'Pedido',
            'cant' => 'Cant',
            'feccre' => 'Feccre',
            'fecmod' => 'Fecmod',
            'usumod' => 'Usumod',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdcita0()
    {
        return $this->hasOne(Cita::className(), ['idcita' => 'idcita']);
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
