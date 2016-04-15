<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "producto".
 *
 * @property integer $idpro
 * @property integer $idemp
 * @property string $codigo
 * @property string $nombre
 * @property string $descripcion
 * @property integer $vlrsiniva
 * @property integer $iva
 * @property string $estado
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Facturad[] $facturads
 * @property Empresa $idemp0
 * @property Usuario $usumod0
 */
class Producto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'producto';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idemp', 'vlrsiniva', 'iva', 'usumod'], 'integer'],
            [['descripcion'], 'string'],
            [['feccre', 'fecmod'], 'safe'],
            [['codigo'], 'string', 'max' => 5],
            [['nombre'], 'string', 'max' => 40],
            [['estado'], 'string', 'max' => 8],
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
            'idpro' => 'Idpro',
            'idemp' => 'Idemp',
            'codigo' => 'Codigo',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'vlrsiniva' => 'Vlrsiniva',
            'iva' => 'Iva',
            'estado' => 'Estado',
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
        return $this->hasMany(Facturad::className(), ['idpro' => 'idpro']);
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
