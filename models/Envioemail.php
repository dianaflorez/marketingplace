<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "envioemail".
 *
 * @property integer $idenv
 * @property integer $idemp
 * @property integer $idusu
 * @property integer $idcli
 * @property string $fecha
 * @property string $email
 * @property string $asunto
 * @property string $contenido
 * @property string $estado
 *
 * @property Cliente $idcli0
 * @property Empresa $idemp0
 * @property Usuario $idusu0
 */
class Envioemail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'envioemail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idemp', 'idusu', 'idcli', 'email', 'contenido'], 'required'],
            [['idemp', 'idusu', 'idcli'], 'integer'],
            [['fecha'], 'safe'],
            [['email', 'contenido'], 'string'],
            ['email', 'email'],
            [['asunto', 'estado'], 'string', 'max' => 30],
            [['idcli'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::className(), 'targetAttribute' => ['idcli' => 'idcli']],
            [['idemp'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['idemp' => 'idemp']],
            [['idusu'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['idusu' => 'idusu']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idenv' => 'Idenv',
            'idemp' => 'Idemp',
            'idusu' => 'Idusu',
            'idcli' => 'Idcli',
            'fecha' => 'Fecha',
            'email' => 'Email',
            'asunto' => 'Asunto',
            'contenido' => 'Contenido',
            'estado' => 'Estado',
        ];
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
}
