<?php
 
namespace app\models;

use Yii;
use yii\base\Model;
 
class FormUploadlogo extends model{
  
    public $file;
    public $info;
     
    public function rules()
    {
        return [
            [['info'], 'string', 'max' => 24],

            ['file', 'file', 
             'skipOnEmpty' => false,
             'uploadRequired' => 'No has seleccionado ningún archivo', //Error
             'maxSize' => 256*256*1, //1 MB
             'tooBig' => 'El tamaño máximo permitido es 128k', //Error
             'minSize' => 10, //10 Bytes
             'tooSmall' => 'El tamaño mínimo permitido son 10 BYTES', //Error
             'extensions' => 'jpg, png',
             'wrongExtension' => 'El archivo {file} no contiene una extensión permitida {extensions}', //Error
             'maxFiles' => 2,
             'tooMany' => 'El máximo de archivos permitidos son {limit}', //Error

             ],
        ]; 
    } 
 
 public function attributeLabels()
 {
  return [
   'file' => 'Seleccionar imagen de maximo 300k:',
   'info' => 'Nombre Imagen'
  ];
 }
}
