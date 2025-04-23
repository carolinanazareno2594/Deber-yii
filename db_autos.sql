-- Creación de la base de datos
CREATE DATABASE IF NOT EXISTS db_autos;
USE db_autos;

-- Tabla marcas (Normalización: contiene información única sobre cada marca)
CREATE TABLE marcas (
    id_marca INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    pais_origen VARCHAR(50),
    fecha_fundacion DATE,
    logo_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla modelos (Normalización: relaciona modelos con marcas)
CREATE TABLE modelos (
    id_modelo INT AUTO_INCREMENT PRIMARY KEY,
    id_marca INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    año_inicio INT,
    año_fin INT,
    tipo VARCHAR(50), -- SUV, Sedan, Hatchback, etc.
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_marca) REFERENCES marcas(id_marca) ON DELETE CASCADE
);

-- Tabla vehiculos (Normalización: detalles específicos de cada vehículo)
CREATE TABLE vehiculos (
    id_vehiculo INT AUTO_INCREMENT PRIMARY KEY,
    id_modelo INT NOT NULL,
    vin VARCHAR(17), -- Vehicle Identification Number
    año INT NOT NULL,
    color VARCHAR(50),
    kilometraje INT DEFAULT 0,
    precio DECIMAL(10, 2) NOT NULL,
    disponible BOOLEAN DEFAULT TRUE,
    descripcion TEXT,
    imagen_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_modelo) REFERENCES modelos(id_modelo) ON DELETE CASCADE
);

-- Tabla clientes (Normalización: información de clientes separada)
CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE,
    telefono VARCHAR(20),
    direccion VARCHAR(255),
    ciudad VARCHAR(100),
    fecha_registro DATE DEFAULT (CURRENT_DATE),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabla ventas (Normalización: relación muchos a muchos entre vehículos y clientes)
CREATE TABLE ventas (
    id_venta INT AUTO_INCREMENT PRIMARY KEY,
    id_vehiculo INT NOT NULL,
    id_cliente INT NOT NULL,
    fecha_venta DATE NOT NULL DEFAULT (CURRENT_DATE),
    precio_venta DECIMAL(10, 2) NOT NULL,
    metodo_pago VARCHAR(50),
    estado VARCHAR(50) DEFAULT 'Completada', -- Completada, Pendiente, Cancelada
    notas TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_vehiculo) REFERENCES vehiculos(id_vehiculo) ON DELETE RESTRICT,
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente) ON DELETE RESTRICT
);

-- Datos de muestra para la tabla marcas
INSERT INTO marcas (nombre, pais_origen, fecha_fundacion) VALUES
('Toyota', 'Japón', '1937-08-28'),
('Ford', 'Estados Unidos', '1903-06-16'),
('Volkswagen', 'Alemania', '1937-05-28'),
('Honda', 'Japón', '1948-09-24'),
('Chevrolet', 'Estados Unidos', '1911-11-03');

-- Datos de muestra para la tabla modelos
INSERT INTO modelos (id_marca, nombre, año_inicio, tipo) VALUES
(1, 'Corolla', 1966, 'Sedan'),
(1, 'RAV4', 1994, 'SUV'),
(2, 'Mustang', 1964, 'Deportivo'),
(2, 'Explorer', 1990, 'SUV'),
(3, 'Golf', 1974, 'Hatchback'),
(4, 'Civic', 1972, 'Sedan'),
(5, 'Camaro', 1966, 'Deportivo');

-- Datos de muestra para la tabla vehiculos
INSERT INTO vehiculos (id_modelo, vin, año, color, kilometraje, precio, descripcion) VALUES
(1, 'JT2BF22K1W0123456', 2020, 'Rojo', 15000, 18500.00, 'Toyota Corolla en excelente estado'),
(2, 'JTMZD33V365123456', 2021, 'Blanco', 12000, 25500.00, 'Toyota RAV4 con todos los extras'),
(3, '1FA6P8CF2L5123456', 2022, 'Negro', 5000, 42000.00, 'Ford Mustang GT'),
(5, 'WVWZZZ1JZXW123456', 2021, 'Azul', 18000, 22000.00, 'Volkswagen Golf versión especial'),
(6, 'SHHFK7H40KU123456', 2020, 'Gris', 20000, 19500.00, 'Honda Civic Touring');

-- Datos de muestra para la tabla clientes
INSERT INTO clientes (nombre, apellido, email, telefono, direccion, ciudad) VALUES
('Juan', 'Pérez', 'juan.perez@email.com', '555-1234', 'Calle Principal 123', 'Ciudad A'),
('María', 'González', 'maria.gon@email.com', '555-5678', 'Avenida Central 456', 'Ciudad B'),
('Carlos', 'Rodríguez', 'carlos.rod@email.com', '555-9012', 'Calle Secundaria 789', 'Ciudad A'),
('Ana', 'Martínez', 'ana.mar@email.com', '555-3456', 'Boulevard Norte 321', 'Ciudad C'),
('Pedro', 'López', 'pedro.lopez@email.com', '555-7890', 'Calle Sur 654', 'Ciudad B');

-- Datos de muestra para la tabla ventas
INSERT INTO ventas (id_vehiculo, id_cliente, fecha_venta, precio_venta, metodo_pago) VALUES
(1, 3, '2023-01-15', 18000.00, 'Transferencia'),
(2, 1, '2023-02-20', 25000.00, 'Financiamiento'),
(3, 4, '2023-03-10', 41500.00, 'Efectivo'),
(5, 2, '2023-04-05', 21500.00, 'Financiamiento');

-- Actualizar la disponibilidad de los vehículos vendidos
UPDATE vehiculos SET disponible = FALSE WHERE id_vehiculo IN (1, 2, 3, 5);
