<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "facturad".
 *
 * @property integer $idfd
 * @property integer $idfh
 * @property integer $idemp
 * @property integer $idpro
 * @property string $descripcion
 * @property double $vlr1
 * @property integer $pordes
 * @property double $vlr2
 * @property double $descuento
 * @property integer $qty
 * @property double $valor
 * @property integer $poriva
 * @property double $vlriva
 * @property double $neto
 * @property double $total
 * @property string $fecini
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Empresa $idemp0
 * @property Facturah $idfh0
 * @property Producto $idpro0
 * @property Usuario $usumod0
 */
class Facturad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'facturad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idfh', 'idemp', 'idpro', 'pordes', 'qty', 'poriva', 'usumod'], 'integer'],
            [['descripcion'], 'string'],
            [['vlr1', 'vlriva', 'neto', 'total', 'usumod'], 'required'],
            [['vlr1', 'vlr2', 'descuento', 'valor', 'vlriva', 'neto', 'total'], 'number'],
            [['fecini', 'fecmod'], 'safe'],
            [['idemp'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['idemp' => 'idemp']],
            [['idfh'], 'exist', 'skipOnError' => true, 'targetClass' => Facturah::className(), 'targetAttribute' => ['idfh' => 'idfh']],
            [['idpro'], 'exist', 'skipOnError' => true, 'targetClass' => Producto::className(), 'targetAttribute' => ['idpro' => 'idpro']],
            [['usumod'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['usumod' => 'idusu']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idfd' => 'Idfd',
            'idfh' => 'Idfh',
            'idemp' => 'Idemp',
            'idpro' => 'Producto',
            'descripcion' => 'Descripcion',
            'vlr1' => 'Vlr1',
            'pordes' => 'Pordes',
            'vlr2' => 'Vlr2',
            'descuento' => 'Descuento',
            'qty' => 'Qty',
            'valor' => 'Valor',
            'poriva' => '%iva',
            'vlriva' => 'Iva',
            'neto' => 'Neto',
            'total' => 'Total',
            'fecini' => 'Creacion',
            'fecmod' => 'Modificacion',
            'usumod' => 'Quien Modifico',
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
    public function getIdpro0()
    {
        return $this->hasOne(Producto::className(), ['idpro' => 'idpro']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsumod0()
    {
        return $this->hasOne(Usuario::className(), ['idusu' => 'usumod']);
    }
}
