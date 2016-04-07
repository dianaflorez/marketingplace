<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo".
 *
 * @property integer $idtipo
 * @property string $tabla
 * @property integer $orden
 * @property string $nombre
 * @property string $descripcion
 * @property string $feccre
 * @property string $fecmod
 * @property integer $usumod
 *
 * @property Cliente[] $clientes
 * @property Dirtel[] $dirtels
 * @property Usuario[] $usuarios
 */
class Tipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orden', 'usumod'], 'integer'],
            [['nombre'], 'required'],
            [['descripcion'], 'string'],
            [['feccre', 'fecmod'], 'safe'],
            [['tabla', 'nombre'], 'string', 'max' => 17],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idtipo' => 'Idtipo',
            'tabla' => 'Tabla',
            'orden' => 'Orden',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'feccre' => 'Feccre',
            'fecmod' => 'Fecmod',
            'usumod' => 'Usumod',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientes()
    {
        return $this->hasMany(Cliente::className(), ['idtide' => 'idtipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDirtels()
    {
        return $this->hasMany(Dirtel::className(), ['idtipo' => 'idtipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuario::className(), ['idtide' => 'idtipo']);
    }
}
