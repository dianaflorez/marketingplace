<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "facturah".
 *
 * @property integer $idfh
 * @property integer $idemp
 * @property integer $idusu
 * @property integer $idcli
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
 * @property double $trm
 * @property string $moneda
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Facturad[] $facturads
 * @property Cliente $idcli0
 * @property Empresa $idemp0
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
            [['idemp', 'idusu', 'refpago', 'totalnormal', 'neto', 'vlriva', 'total'], 'required'],
            [['idemp', 'idusu', 'idcli', 'codigo', 'usumod'], 'integer'],
            [['totalnormal', 'totaldes', 'vlrdes', 'neto', 'vlriva', 'total', 'trm'], 'number'],
            [['fecha', 'feccre', 'fecmod'], 'safe'],
            [['refpago'], 'string', 'max' => 27],
            [['prefijo'], 'string', 'max' => 5],
            [['estado'], 'string', 'max' => 8],
            [['tipo'], 'string', 'max' => 7],
            [['descripcion'], 'string', 'max' => 50],
            [['moneda'], 'string', 'max' => 3],
            [['refpago'], 'unique'],
            [['idcli'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::className(), 'targetAttribute' => ['idcli' => 'idcli']],
            [['idemp'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['idemp' => 'idemp']],
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
            'idemp' => 'Empresa',
            'idusu' => 'Idusu',
            'idcli' => 'Cliente',
            'refpago' => 'Referencia',
            'prefijo' => 'Prefijo',
            'codigo' => 'Codigo',
            'totalnormal' => 'Totalnormal',
            'totaldes' => 'Descuento',
            'vlrdes' => 'Vlrdes',
            'neto' => 'Neto',
            'vlriva' => 'Iva',
            'total' => 'TOTAL',
            'estado' => 'Estado',
            'tipo' => 'Tipo',
            'fecha' => 'Fecha',
            'descripcion' => 'Descripcion',
            'trm' => 'Trm',
            'moneda' => 'Moneda',
            'feccre' => 'Creado',
            'fecmod' => 'Modificado',
            'usumod' => 'Quien modifico',
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
    public function getIdcli0()
    {
        return $this->hasOne(Cliente::className(), ['idcli' => 'idcli']);
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
