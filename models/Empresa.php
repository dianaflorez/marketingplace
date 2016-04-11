<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "empresa".
 *
 * @property integer $idemp
 * @property string $nombre
 * @property string $nit
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Infempresa[] $infempresas
 * @property Planaccion[] $planaccions
 * @property Planmarketing[] $planmarketings
 * @property Producto[] $productos
 * @property Usuario[] $usuarios
 */
class Empresa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['feccre', 'fecmod'], 'safe'],
            [['usumod'], 'integer'],
            [['nombre', 'nit'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idemp' => 'Id',
            'nombre' => 'Nombre',
            'nit' => 'Nit',
            'feccre' => 'Creacion',
            'fecmod' => 'Modificacion',
            'usumod' => 'Quien Modifico?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInfempresas()
    {
        return $this->hasMany(Infempresa::className(), ['idemp' => 'idemp']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanaccions()
    {
        return $this->hasMany(Planaccion::className(), ['idemp' => 'idemp']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlanmarketings()
    {
        return $this->hasMany(Planmarketing::className(), ['idemp' => 'idemp']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductos()
    {
        return $this->hasMany(Producto::className(), ['idemp' => 'idemp']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['idemp' => 'idemp']);
    }
}
