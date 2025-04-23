<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "ventas".
 *
 * @property int $id_venta
 * @property int $id_vehiculo
 * @property int $id_cliente
 * @property string $fecha_venta
 * @property float $precio_venta
 * @property string|null $metodo_pago
 * @property string|null $estado
 * @property string|null $notas
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Cliente $cliente
 * @property Vehiculo $vehiculo
 */
class Venta extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ventas';
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
            [['id_vehiculo', 'id_cliente', 'precio_venta'], 'required'],
            [['id_vehiculo', 'id_cliente'], 'integer'],
            [['fecha_venta', 'created_at', 'updated_at'], 'safe'],
            [['precio_venta'], 'number'],
            // Agregar validación para el rango del precio (DECIMAL(10,2) permite hasta 99,999,999.99)
            [['precio_venta'], 'number', 'max' => 99999999.99, 'tooBig' => 'El precio no puede exceder los 99,999,999.99'],
            [['notas'], 'string'],
            [['metodo_pago', 'estado'], 'string', 'max' => 50],
            [['id_vehiculo'], 'exist', 'skipOnError' => true, 'targetClass' => Vehiculo::class, 'targetAttribute' => ['id_vehiculo' => 'id_vehiculo']],
            [['id_cliente'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::class, 'targetAttribute' => ['id_cliente' => 'id_cliente']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_venta' => 'ID',
            'id_vehiculo' => 'Vehículo',
            'id_cliente' => 'Cliente',
            'fecha_venta' => 'Fecha de Venta',
            'precio_venta' => 'Precio de Venta',
            'metodo_pago' => 'Método de Pago',
            'estado' => 'Estado',
            'notas' => 'Notas',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
        ];
    }

    /**
     * Gets query for [[Cliente]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCliente()
    {
        return $this->hasOne(Cliente::class, ['id_cliente' => 'id_cliente']);
    }

    /**
     * Gets query for [[Vehiculo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getVehiculo()
    {
        return $this->hasOne(Vehiculo::class, ['id_vehiculo' => 'id_vehiculo']);
    }
    
    /**
     * @return array list of available payment methods
     */
    public static function getMetodosPago()
    {
        return [
            'Efectivo' => 'Efectivo',
            'Transferencia' => 'Transferencia',
            'Tarjeta de Crédito' => 'Tarjeta de Crédito',
            'Financiamiento' => 'Financiamiento',
            'Otro' => 'Otro'
        ];
    }
    
    /**
     * @return array list of available states
     */
    public static function getEstados()
    {
        return [
            'Completada' => 'Completada',
            'Pendiente' => 'Pendiente',
            'Cancelada' => 'Cancelada'
        ];
    }
    
    /**
     * Before saving, ensure precio_venta is properly formatted for the database
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        // Asegurar que precio_venta sea un número válido y esté dentro del rango permitido
        if (isset($this->precio_venta)) {
            // Convertir a float para asegurar formato numérico correcto
            $this->precio_venta = (float) str_replace(',', '.', $this->precio_venta);
            
            // Validar que no exceda el máximo permitido por DECIMAL(10,2)
            if ($this->precio_venta > 99999999.99) {
                $this->addError('precio_venta', 'El precio no puede exceder los 99,999,999.99');
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * After saving a sale, mark the vehicle as not available
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        
        if ($insert || isset($changedAttributes['estado']) && $this->estado == 'Completada') {
            $vehiculo = $this->vehiculo;
            $vehiculo->disponible = false;
            $vehiculo->save(false);
        }
    }
}
