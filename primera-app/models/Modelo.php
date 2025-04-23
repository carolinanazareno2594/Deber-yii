<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "modelos".
 *
 * @property int $id_modelo
 * @property int $id_marca
 * @property string $nombre
 * @property int|null $año_inicio
 * @property int|null $año_fin
 * @property string|null $tipo
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Marca $marca
 * @property Vehiculo[] $vehiculos
 */
class Modelo extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'modelos';
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
            [['id_marca', 'nombre'], 'required'],
            [['id_marca', 'año_inicio', 'año_fin'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nombre'], 'string', 'max' => 100],
            [['tipo'], 'string', 'max' => 50],
            [['id_marca'], 'exist', 'skipOnError' => true, 'targetClass' => Marca::class, 'targetAttribute' => ['id_marca' => 'id_marca']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_modelo' => 'ID',
            'id_marca' => 'Marca',
            'nombre' => 'Nombre',
            'año_inicio' => 'Año de Inicio',
            'año_fin' => 'Año de Fin',
            'tipo' => 'Tipo',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
        ];
    }

    /**
     * Gets query for [[Marca]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMarca()
    {
        return $this->hasOne(Marca::class, ['id_marca' => 'id_marca']);
    }

    /**
     * Gets query for [[Vehiculos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculos()
    {
        return $this->hasMany(Vehiculo::class, ['id_modelo' => 'id_modelo']);
    }
    
    /**
     * Gets a formatted name with the brand for dropdowns
     * 
     * @return string
     */
    public function getNombreCompleto()
    {
        return $this->marca->nombre . ' ' . $this->nombre;
    }
}
