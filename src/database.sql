-- Creación de la base de datos con UTF-8
CREATE DATABASE IF NOT EXISTS tienda_valoraciones
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE tienda_valoraciones;

-- Creación de la tabla productos con UTF-8
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10, 2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Creación de la tabla usuarios con UTF-8
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_admin TINYINT(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Creación de la tabla votos con UTF-8
CREATE TABLE votos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cantidad INT DEFAULT 0,
    idPr INT NOT NULL,
    idUs VARCHAR(20) NOT NULL,
    CONSTRAINT fk_votos_usu FOREIGN KEY (idUs) REFERENCES usuarios(usuario) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_votos_pro FOREIGN KEY (idPr) REFERENCES productos(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Añadimos productos
INSERT INTO productos (nombre, descripcion, precio) VALUES
('Laptop Gamer', 'Potente laptop para gaming con gráficos de última generación', 1299.99),
('Smartphone 5G', 'Teléfono inteligente con conectividad 5G y cámara de alta resolución', 799.99),
('Auriculares Bluetooth', 'Auriculares inalámbricos con cancelación de ruido', 199.99),
('Tablet 10"', 'Tablet de 10 pulgadas con pantalla retina y lápiz incluido', 499.99),
('Smartwatch', 'Reloj inteligente con monitor de ritmo cardíaco y GPS', 249.99),
('Cámara DSLR', 'Cámara réflex digital con sensor de 24MP y grabación 4K', 899.99),
('Altavoz Inteligente', 'Altavoz con asistente de voz integrado y sonido 360°', 129.99),
('Monitor 4K', 'Monitor de 27" con resolución 4K y tecnología HDR', 399.99),
('Teclado Mecánico', 'Teclado gaming mecánico con retroiluminación RGB', 149.99),
('Impresora Multifunción', 'Impresora, escáner y copiadora con conectividad WiFi', 179.99);

INSERT INTO usuarios (usuario, password, is_admin) VALUES
('admin', 'admin', 1),
('ana', '1234', 0),
('juan', '1234', 0),
('maria', '1234', 0),
('pedro', '1234', 0);