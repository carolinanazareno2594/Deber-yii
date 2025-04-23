<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "clientes".
 *
 * @property int $id_cliente
 * @property string $nombre
 * @property string $apellido
 * @property string|null $email
 * @property string|null $telefono
 * @property string|null $direccion
 * @property string|null $ciudad
 * @property string|null $fecha_registro
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Venta[] $ventas
 */
class Cliente extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clientes';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido'], 'required'],
            [['fecha_registro', 'created_at', 'updated_at'], 'safe'],
            [['nombre', 'apellido'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 100],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['telefono'], 'string', 'max' => 20],
            [['direccion'], 'string', 'max' => 255],
            [['ciudad'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_cliente' => 'ID',
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'email' => 'Email',
            'telefono' => 'Teléfono',
            'direccion' => 'Dirección',
            'ciudad' => 'Ciudad',
            'fecha_registro' => 'Fecha de Registro',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
        ];
    }

    /**
     * Gets query for [[Ventas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVentas()
    {
        return $this->hasMany(Venta::class, ['id_cliente' => 'id_cliente']);
    }
    
    /**
     * Returns the full name of the client
     * 
     * @return string
     */
    public function getNombreCompleto()
    {
        return $this->nombre . ' ' . $this->apellido;
    }
}
