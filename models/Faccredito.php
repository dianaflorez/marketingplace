<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "faccredito".
 *
 * @property integer $idcre
 * @property integer $idfh
 * @property integer $idemp
 * @property double $totalfh
 * @property double $abono
 * @property double $saldo
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Empresa $idemp0
 * @property Facturah $idfh0
 * @property Usuario $usumod0
 */
class Faccredito extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faccredito';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idfh', 'idemp'], 'required'],
            [['idfh', 'idemp', 'usumod'], 'integer'],
            [['totalfh', 'abono', 'saldo'], 'number'],
            [['feccre', 'fecmod'], 'safe'],
            [['idemp'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['idemp' => 'idemp']],
            [['idfh'], 'exist', 'skipOnError' => true, 'targetClass' => Facturah::className(), 'targetAttribute' => ['idfh' => 'idfh']],
            [['usumod'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usumod' => 'idusu']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idcre' => 'Idcre',
            'idfh' => 'Idfh',
            'idemp' => 'Idemp',
            'totalfh' => 'Totalfh',
            'abono' => 'Abono',
            'saldo' => 'Saldo',
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
    public function getIdfh0()
    {
        return $this->hasOne(Facturah::className(), ['idfh' => 'idfh']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsumod0()
    {
        return $this->hasOne(Usuario::className(), ['idusu' => 'usumod']);
    }
}
