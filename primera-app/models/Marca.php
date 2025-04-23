<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "marcas".
 *
 * @property int $id_marca
 * @property string $nombre
 * @property string|null $pais_origen
 * @property string|null $fecha_fundacion
 * @property string|null $logo_url
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Modelo[] $modelos
 */
class Marca extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'marcas';
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
            [['nombre'], 'required'],
            [['fecha_fundacion', 'created_at', 'updated_at'], 'safe'],
            [['nombre', 'pais_origen'], 'string', 'max' => 50],
            [['logo_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_marca' => 'ID',
            'nombre' => 'Nombre',
            'pais_origen' => 'País de Origen',
            'fecha_fundacion' => 'Fecha de Fundación',
            'logo_url' => 'Logo URL',
            'created_at' => 'Creado',
            'updated_at' => 'Actualizado',
        ];
    }

    /**
     * Gets query for [[Modelos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getModelos()
    {
        return $this->hasMany(Modelo::class, ['id_marca' => 'id_marca']);
    }
}
