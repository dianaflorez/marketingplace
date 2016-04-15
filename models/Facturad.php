<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "facturad".
 *
 * @property integer $idfd
 * @property integer $idfh
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
 * @property string $fechaini
 * @property string $fechamod
 * @property integer $usumod
 *
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
            [['idfh', 'idpro', 'pordes', 'qty', 'poriva', 'usumod'], 'integer'],
            [['descripcion'], 'string'],
            [['vlr1', 'vlriva', 'neto', 'total', 'usumod'], 'required'],
            [['vlr1', 'vlr2', 'descuento', 'valor', 'vlriva', 'neto', 'total'], 'number'],
            [['fechaini', 'fechamod'], 'safe'],
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
            'idpro' => 'Idpro',
            'descripcion' => 'Descripcion',
            'vlr1' => 'Vlr1',
            'pordes' => 'Pordes',
            'vlr2' => 'Vlr2',
            'descuento' => 'Descuento',
            'qty' => 'Qty',
            'valor' => 'Valor',
            'poriva' => 'Poriva',
            'vlriva' => 'Vlriva',
            'neto' => 'Neto',
            'total' => 'Total',
            'fechaini' => 'Fechaini',
            'fechamod' => 'Fechamod',
            'usumod' => 'Usumod',
        ];
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
