<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "facturah".
 *
 * @property integer $idfh
 * @property integer $idusu
 * @property string $refpago
 * @property string $prefijo
 * @property integer $codigo
 * @property double $totalnormal
 * @property double $totaldes
 * @property double $vlrdes
 * @property double $neto
 * @property double $vlriva
 * @property double $total
 * @property string $estado
 * @property string $tipo
 * @property string $fecha
 * @property string $descripcion
 * @property integer $trm
 * @property string $moneda
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Facturad[] $facturads
 * @property Usuario $idusu0
 * @property Usuario $usumod0
 */
class Facturah extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'facturah';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idusu', 'refpago', 'totalnormal', 'neto', 'vlriva', 'total'], 'required'],
            [['idusu', 'codigo', 'trm', 'usumod'], 'integer'],
            [['totalnormal', 'totaldes', 'vlrdes', 'neto', 'vlriva', 'total'], 'number'],
            [['fecha', 'feccre', 'fecmod'], 'safe'],
            [['refpago'], 'string', 'max' => 27],
            [['prefijo'], 'string', 'max' => 5],
            [['estado'], 'string', 'max' => 8],
            [['tipo'], 'string', 'max' => 2],
            [['descripcion'], 'string', 'max' => 50],
            [['moneda'], 'string', 'max' => 3],
            [['refpago'], 'unique'],
            [['idusu'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idusu' => 'idusu']],
            [['usumod'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usumod' => 'idusu']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idfh' => 'Idfh',
            'idusu' => 'Idusu',
            'refpago' => 'Refpago',
            'prefijo' => 'Prefijo',
            'codigo' => 'Codigo',
            'totalnormal' => 'Totalnormal',
            'totaldes' => 'Totaldes',
            'vlrdes' => 'Vlrdes',
            'neto' => 'Neto',
            'vlriva' => 'Vlriva',
            'total' => 'Total',
            'estado' => 'Estado',
            'tipo' => 'Tipo',
            'fecha' => 'Fecha',
            'descripcion' => 'Descripcion',
            'trm' => 'Trm',
            'moneda' => 'Moneda',
            'feccre' => 'Feccre',
            'fecmod' => 'Fecmod',
            'usumod' => 'Usumod',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturads()
    {
        return $this->hasMany(Facturad::className(), ['idfh' => 'idfh']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdusu0()
    {
        return $this->hasOne(Usuario::className(), ['idusu' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsumod0()
    {
        return $this->hasOne(Usuario::className(), ['idusu' => 'usumod']);
    }
}
