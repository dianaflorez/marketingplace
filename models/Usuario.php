<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property integer $idusu
 * @property string $nombre1
 * @property string $nombre2
 * @property string $apellido1
 * @property string $apellido2
 * @property integer $idtide
 * @property string $identificacion
 * @property string $login
 * @property string $clave
 * @property string $authkey
 * @property string $accesstoken
 * @property integer $role
 * @property integer $activo
 * @property string $estado
 * @property integer $idemp
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Accion[] $accions
 * @property Cita[] $citas
 * @property Cita[] $citas0
 * @property Cliente[] $clientes
 * @property Dirtel[] $dirtels
 * @property Elemento[] $elementos
 * @property Encuesta[] $encuestas
 * @property Encuesta[] $encuestas0
 * @property Facturad[] $facturads
 * @property Facturah[] $facturahs
 * @property Facturah[] $facturahs0
 * @property Infempresa[] $infempresas
 * @property Planaccion[] $planaccions
 * @property Planaccion[] $planaccions0
 * @property Planmarketing[] $planmarketings
 * @property Pmcontenido[] $pmcontenidos
 * @property Producto[] $productos
 * @property Empresa $idemp0
 * @property Tipo $idtide0
 */
class Usuario extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idtide', 'role', 'activo', 'idemp', 'usumod'], 'integer'],
            [['identificacion', 'login', 'clave', 'authkey', 'accesstoken', 'idemp'], 'required'],
            [['feccre', 'fecmod'], 'safe'],
            [['nombre1', 'nombre2', 'apellido1', 'apellido2'], 'string', 'max' => 30],
            [['identificacion'], 'string', 'max' => 20],
            [['login', 'clave', 'authkey', 'accesstoken'], 'string', 'max' => 40],
            [['estado'], 'string', 'max' => 8],
            [['login'], 'unique'],
            [['idemp'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['idemp' => 'idemp']],
            [['idtide'], 'exist', 'skipOnError' => true, 'targetClass' => Tipo::className(), 'targetAttribute' => ['idtide' => 'idtipo']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idusu' => 'Id',
            'nombre1' => 'Nombre1',
            'nombre2' => 'Nombre2',
            'apellido1' => 'Apellido1',
            'apellido2' => 'Apellido2',
            'idtide' => 'Tipo ident.',
            'identificacion' => 'Identificacion',
            'login' => 'Login',
            'clave' => 'Clave',
            'authkey' => 'Authkey',
            'accesstoken' => 'Accesstoken',
            'role' => 'Role',
            'activo' => 'Activo',
            'estado' => 'Estado',
            'idemp' => 'Empresa',
            'feccre' => 'Fecha creacion',
            'fecmod' => 'Fecha modificacion',
            'usumod' => 'Quien modifico',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccions()
    {
        return $this->hasMany(Accion::className(), ['usumod' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitas()
    {
        return $this->hasMany(Cita::className(), ['idusu' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCitas0()
    {
        return $this->hasMany(Cita::className(), ['usumod' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Cliente::className(), ['usumod' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDirtels()
    {
        return $this->hasMany(Dirtel::className(), ['usumod' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getElementos()
    {
        return $this->hasMany(Elemento::className(), ['usumod' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEncuestas()
    {
        return $this->hasMany(Encuesta::className(), ['idusu' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEncuestas0()
    {
        return $this->hasMany(Encuesta::className(), ['usumod' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturads()
    {
        return $this->hasMany(Facturad::className(), ['usumod' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturahs()
    {
        return $this->hasMany(Facturah::className(), ['idusu' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFacturahs0()
    {
        return $this->hasMany(Facturah::className(), ['usumod' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInfempresas()
    {
        return $this->hasMany(Infempresa::className(), ['usumod' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanaccions()
    {
        return $this->hasMany(Planaccion::className(), ['idresponsable' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanaccions0()
    {
        return $this->hasMany(Planaccion::className(), ['usumod' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanmarketings()
    {
        return $this->hasMany(Planmarketing::className(), ['usumod' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPmcontenidos()
    {
        return $this->hasMany(Pmcontenido::className(), ['usumod' => 'idusu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::className(), ['usumod' => 'idusu']);
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
    public function getIdtide0()
    {
        return $this->hasOne(Tipo::className(), ['idtipo' => 'idtide']);
    }
}
