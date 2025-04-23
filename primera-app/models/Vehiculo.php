<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "vehiculos".
 *
 * @property int $id_vehiculo
 * @property int $id_modelo
 * @property string|null $vin
 * @property int $año
 * @property string|null $color
 * @property int|null $kilometraje
 * @property float $precio
 * @property bool|null $disponible
 * @property string|null $descripcion
 * @property string|null $imagen_url
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Modelo $modelo
 * @property Venta[] $ventas
 */
class Vehiculo extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehiculos';
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
            [['id_modelo', 'año', 'precio'], 'required'],
            [['id_modelo', 'año', 'kilometraje'], 'integer'],
            [['precio'], 'number'],
            [['disponible'], 'boolean'],
            [['descripcion'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['vin'], 'string', 'max' => 17],
            [['color'], 'string', 'max' => 50],
            [['imagen_url'], 'string', 'max' => 255],
            [['id_modelo'], 'exist', 'skipOnError' => true, 'targetClass' => Modelo::class, 'targetAttribute' => ['id_modelo' => 'id_modelo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_vehiculo' => 'ID',
            'id_modelo' => 'Modelo',
            'vin' => 'VIN',
            'año' => 'Año',
            'color' => 'Color',
            'kilometraje' => 'Kilometraje',
            'precio' => 'Precio',
            'disponible' => 'Disponible',
            'descripcion' => 'Descripción',
            'imagen_url' => 'Imagen URL',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
        ];
    }

    /**
     * Gets query for [[Modelo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModelo()
    {
        return $this->hasOne(Modelo::class, ['id_modelo' => 'id_modelo']);
    }

    /**
     * Gets query for [[Ventas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVentas()
    {
        return $this->hasMany(Venta::class, ['id_vehiculo' => 'id_vehiculo']);
    }
    
    /**
     * Returns the full name of the vehicle with model and brand
     * 
     * @return string
     */
    public function getNombreCompleto()
    {
        return $this->modelo->marca->nombre . ' ' . $this->modelo->nombre . ' (' . $this->año . ')';
    }
}
