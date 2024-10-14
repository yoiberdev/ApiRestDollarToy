CREATE DATABASE db_dollartoy;

USE db_dollartoy;

CREATE TABLE tb_rol (
    id_rol INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50)
);

CREATE TABLE tb_usuario (
    id_usuario INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    email VARCHAR(50),
    celular INT,
    contraseña VARCHAR(100),
    fecha_registro DATETIME,
    id_usuario_rol INT,
    FOREIGN KEY (id_usuario_rol) REFERENCES tb_rol(id_rol) ON DELETE CASCADE
);

CREATE TABLE tb_categoria (
    id_categoria INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT
);

CREATE TABLE tb_producto (
    id_producto INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    precio FLOAT,
    id_categoria_producto INT NOT NULL,
    imagen_url VARCHAR(255),
    FOREIGN KEY (id_categoria_producto) REFERENCES tb_categoria(id_categoria) ON DELETE CASCADE
);

CREATE TABLE tb_cliente (
    id_cliente INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50),
    apellido VARCHAR(50),
    email VARCHAR(50),
    fecha_registro DATETIME
);

CREATE TABLE tb_sedes (
    id_sede INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    direccion VARCHAR(255),
    ciudad VARCHAR(100)
);

CREATE TABLE tb_sedeproducto (
    id_sedeproducto INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_sede INT NOT NULL,
    id_producto INT NOT NULL,
    stock_disponible INT,
    FOREIGN KEY (id_sede) REFERENCES tb_sedes(id_sede),
    FOREIGN KEY (id_producto) REFERENCES tb_producto(id_producto) ON DELETE CASCADE
);

CREATE TABLE tb_metodo_pago (
    id_metodopago INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50)
);

CREATE TABLE tb_venta (
    id_venta INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_venta_usuario INT,
    id_venta_cliente INT,
    cantidad INT,
    fecha_venta DATETIME,
    id_metodopago_venta INT,
    total FLOAT,
    FOREIGN KEY (id_venta_cliente) REFERENCES tb_cliente(id_cliente) ON DELETE CASCADE,
    FOREIGN KEY (id_metodopago_venta) REFERENCES tb_metodo_pago(id_metodopago) ON DELETE CASCADE,
    FOREIGN KEY (id_venta_usuario) REFERENCES tb_usuario(id_usuario) ON DELETE CASCADE
);

CREATE TABLE tb_detalle_venta (
    id_detalle_venta INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_venta INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario FLOAT NOT NULL,
    FOREIGN KEY (id_venta) REFERENCES tb_venta(id_venta) ON DELETE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES tb_producto(id_producto) ON DELETE CASCADE
);


/*------------------------------------------------
--------------------------------------------------
-- INSERCIONES
--------------------------------------------------
--------------------------------------------------*/

-- Insertar filas en la tabla tb_rol
-- INSERT INTO tb_rol (nombre) VALUES
-- ('Administrador'),
-- ('Vendedor');

-- -- Insertar filas en la tabla tb_usuario
-- INSERT INTO tb_usuario (nombre, apellido, email, celular, contraseña, fecha_registro, id_usuario_rol) VALUES
-- ('Juan', 'Pérez', 'juan.perez@example.com', 987654321, 'contraseña1', NOW(), 1),
-- ('Ana', 'Gómez', 'ana.gomez@example.com', 976543210, 'contraseña2', NOW(), 1),
-- ('Luis', 'Fernández', 'luis.fernandez@example.com', 965432109, 'contraseña3', NOW(), 2),
-- ('Marta', 'Díaz', 'marta.diaz@example.com', 954321098, 'contraseña4', NOW(), 2),
-- ('Carlos', 'Martínez', 'carlos.martinez@example.com', 943210987, 'contraseña5', NOW(), 1),
-- ('Sofía', 'López', 'sofia.lopez@example.com', 932109876, 'contraseña6', NOW(), 2),
-- ('Jorge', 'Sánchez', 'jorge.sanchez@example.com', 921098765, 'contraseña7', NOW(), 2),
-- ('Isabel', 'Torres', 'isabel.torres@example.com', 910987654, 'contraseña8', NOW(), 1),
-- ('Fernando', 'Ramírez', 'fernando.ramirez@example.com', 909876543, 'contraseña9', NOW(), 2),
-- ('Patricia', 'Vargas', 'patricia.vargas@example.com', 898765432, 'contraseña10', NOW(), 1),
-- ('Diego', 'Reyes', 'diego.reyes@example.com', 887654321, 'contraseña11', NOW(), 2),
-- ('Verónica', 'Jiménez', 'veronica.jimenez@example.com', 876543210, 'contraseña12', NOW(), 1),
-- ('Andrés', 'Hernández', 'andres.hernandez@example.com', 865432109, 'contraseña13', NOW(), 2),
-- ('Laura', 'Mendoza', 'laura.mendoza@example.com', 854321098, 'contraseña14', NOW(), 1),
-- ('Rafael', 'Salazar', 'rafael.salazar@example.com', 843210987, 'contraseña15', NOW(), 2);

-- -- Insertar filas en la tabla tb_categoria
-- INSERT INTO tb_categoria (nombre, descripcion) VALUES
-- ('Muñecas', 'Diversas muñecas de diferentes estilos.'),
-- ('Juguetes de construcción', 'Bloques y sets de construcción.'),
-- ('Autos', 'Autos de juguete para coleccionar.'),
-- ('Juegos de mesa', 'Juegos de mesa para toda la familia.'),
-- ('Pelotas', 'Pelotas de diferentes tamaños y usos.'),
-- ('Rompecabezas', 'Rompecabezas de varias piezas y temáticas.'),
-- ('Dinosaurios', 'Figuras de dinosaurios de diferentes tamaños.'),
-- ('Juguetes educativos', 'Juguetes que enseñan mientras juegan.'),
-- ('Accesorios', 'Accesorios para muñecas y figuras.'),
-- ('Bicicletas', 'Bicicletas de juguete y accesorios.');

-- -- Insertar filas en la tabla tb_producto
-- INSERT INTO tb_producto (nombre, descripcion, precio, id_categoria_producto, imagen_url) VALUES
-- ('Muñeca de trapo', 'Muñeca suave y amigable.', 29.99, 1, 'http://ejemplo.com/muñeca1.jpg'),
-- ('Set de bloques', 'Juego de bloques de construcción.', 39.99, 2, 'http://ejemplo.com/bloques1.jpg'),
-- ('Auto de carreras', 'Auto de juguete rápido.', 15.50, 3, 'http://ejemplo.com/auto1.jpg'),
-- ('Juego de mesa', 'Juego de mesa clásico.', 25.00, 4, 'http://ejemplo.com/juego1.jpg'),
-- ('Pelota de fútbol', 'Pelota para jugar al fútbol.', 12.99, 5, 'http://ejemplo.com/pelota1.jpg'),
-- ('Rompecabezas 500 piezas', 'Rompecabezas de paisaje.', 19.99, 6, 'http://ejemplo.com/rompecabezas1.jpg'),
-- ('Dinosaurio de juguete', 'Figura de dinosaurio T-Rex.', 10.50, 7, 'http://ejemplo.com/dinosaurio1.jpg'),
-- ('Juego educativo', 'Juego para aprender matemáticas.', 22.50, 8, 'http://ejemplo.com/juego_educativo1.jpg'),
-- ('Accesorio de muñeca', 'Vestido para muñecas.', 7.50, 9, 'http://ejemplo.com/accesorio1.jpg'),
-- ('Bicicleta de juguete', 'Bicicleta de juguete para niños.', 49.99, 10, 'http://ejemplo.com/bicicleta1.jpg'),
-- ('Muñeca Barbie', 'Muñeca icónica Barbie.', 35.00, 1, 'http://ejemplo.com/muñeca2.jpg'),
-- ('Set de construcción', 'Set para construir un castillo.', 45.99, 2, 'http://ejemplo.com/set_construccion.jpg'),
-- ('Camión de juguete', 'Camión grande para jugar.', 27.00, 3, 'http://ejemplo.com/camion1.jpg'),
-- ('Juego de cartas', 'Juego de cartas para divertirse.', 18.00, 4, 'http://ejemplo.com/juego_cartas.jpg'),
-- ('Pelota de baloncesto', 'Pelota para jugar baloncesto.', 15.00, 5, 'http://ejemplo.com/pelota_baloncesto.jpg');

-- -- Insertar filas en la tabla tb_cliente
-- INSERT INTO tb_cliente (nombre, apellido, email, fecha_registro) VALUES
-- ('Pedro', 'García', 'pedro.garcia@example.com', NOW()),
-- ('Clara', 'Mora', 'clara.mora@example.com', NOW()),
-- ('Ricardo', 'Zamora', 'ricardo.zamora@example.com', NOW()),
-- ('Elena', 'López', 'elena.lopez@example.com', NOW()),
-- ('Felipe', 'Paz', 'felipe.paz@example.com', NOW()),
-- ('Gloria', 'Ortega', 'gloria.ortega@example.com', NOW()),
-- ('Mario', 'Soto', 'mario.soto@example.com', NOW()),
-- ('Victoria', 'Alonso', 'victoria.alonso@example.com', NOW()),
-- ('Santiago', 'Mendoza', 'santiago.mendoza@example.com', NOW()),
-- ('Rosa', 'Cruz', 'rosa.cruz@example.com', NOW()),
-- ('Tomás', 'Salinas', 'tomas.salinas@example.com', NOW()),
-- ('Patricia', 'Guerrero', 'patricia.guerrero@example.com', NOW()),
-- ('Roberto', 'Pérez', 'roberto.perez@example.com', NOW()),
-- ('Camila', 'Fernández', 'camila.fernandez@example.com', NOW()),
-- ('Alejandro', 'Rojas', 'alejandro.rojas@example.com', NOW());

-- -- Insertar filas en la tabla tb_sedes
-- INSERT INTO tb_sedes (nombre, direccion, ciudad) VALUES
-- ('Sede Central', 'Av. Principal 123', 'Lima'),
-- ('Sede Sur', 'Av. Sur 456', 'Lima'),
-- ('Sede Norte', 'Av. Norte 789', 'Lima'),
-- ('Sede Este', 'Av. Este 321', 'Lima');

-- -- Insertar filas en la tabla tb_sedeproducto
-- INSERT INTO tb_sedeproducto (id_sedeproducto, id_sede, id_producto,stock_disponible) VALUES
-- ('SP001', 'S001', 'P001', 5),
-- ('SP002', 'S001', 'P002', 21),
-- ('SP003', 'S001', 'P003', 32),
-- ('SP004', 'S001', 'P004', 21),
-- ('SP005', 'S001', 'P005', 25),
-- ('SP006', 'S002', 'P006', 33),
-- ('SP007', 'S002', 'P007', 51),
-- ('SP008', 'S002', 'P008', 37),
-- ('SP009', 'S003', 'P009', 20),
-- ('SP010', 'S003', 'P010', 48),
-- ('SP011', 'S004', 'P011', 11),
-- ('SP012', 'S004', 'P012', 22),
-- ('SP013', 'S001', 'P013', 31),
-- ('SP014', 'S002', 'P014', 29),
-- ('SP015', 'S003', 'P015', 18),
-- ('SP016', 'S004', 'P001', 23),
-- ('SP017', 'S004', 'P002', 34),
-- ('SP018', 'S003', 'P003', 40),
-- ('SP019', 'S002', 'P004', 10),
-- ('SP020', 'S001', 'P005', 5),
-- ('SP021', 'S002', 'P006', 15),
-- ('SP022', 'S003', 'P007', 20),
-- ('SP023', 'S004', 'P008', 10),
-- ('SP024', 'S001', 'P009', 35),
-- ('SP025', 'S002', 'P010', 20);

-- -- Insertar filas en la tabla tb_metodo_pago
-- INSERT INTO tb_metodo_pago (nombre) VALUES
-- ('Yape'),
-- ('Plin'),
-- ('Efectivo'),
-- ('Transferencia');

-- -- Insertar filas en la tabla tb_venta
-- INSERT INTO tb_venta (id_venta, id_venta_usuario, id_venta_cliente, cantidad, fecha_venta, id_metodopago_venta, total) VALUES
-- ('V001', 'U003', 'C001', 1, NOW(), 'M01', 59.98),
-- ('V002', 'U004', 'C002', 1, NOW(), 'M02', 39.99),
-- ('V003', 'U006', 'C003', 1, NOW(), 'M03', 15.50),
-- ('V004', 'U007', 'C004', 1, NOW(), 'M04', 25.00),
-- ('V005', 'U003', 'C005', 1, NOW(), 'M01', 12.99),
-- ('V006', 'U004', 'C006', 1, NOW(), 'M02', 19.99),
-- ('V007', 'U006', 'C007', 1, NOW(), 'M03', 10.50),
-- ('V008', 'U007', 'C008', 1, NOW(), 'M04', 22.50),
-- ('V009', 'U003', 'C009', 1, NOW(), 'M01', 7.50),
-- ('V010', 'U004', 'C010', 1, NOW(), 'M02', 49.99),
-- ('V011', 'U006', 'C011', 1, NOW(), 'M03', 35.00),
-- ('V012', 'U007', 'C012', 1, NOW(), 'M04', 45.99),
-- ('V013', 'U003', 'C013', 1, NOW(), 'M01', 27.00),
-- ('V014', 'U004', 'C014', 1, NOW(), 'M02', 18.00),
-- ('V015', 'U006', 'C015', 1, NOW(), 'M03', 15.00);

-- -- Insertar filas en la tabla tb_detalle_venta
-- INSERT INTO tb_detalle_venta (id_detalle_venta, id_venta, id_producto, cantidad, precio_unitario) VALUES
-- ('DV001', 'V001', 'P001', 1, 29.99),
-- ('DV002', 'V001', 'P002', 1, 39.99),
-- ('DV003', 'V002', 'P003', 1, 15.50),
-- ('DV004', 'V002', 'P004', 1, 25.00),
-- ('DV005', 'V003', 'P005', 1, 12.99),
-- ('DV006', 'V004', 'P006', 1, 19.99),
-- ('DV007', 'V005', 'P007', 1, 10.50),
-- ('DV008', 'V006', 'P008', 1, 22.50),
-- ('DV009', 'V007', 'P009', 1, 7.50),
-- ('DV010', 'V008', 'P010', 1, 49.99),
-- ('DV011', 'V009', 'P011', 1, 35.00),
-- ('DV012', 'V010', 'P012', 1, 45.99),
-- ('DV013', 'V011', 'P013', 1, 27.00),
-- ('DV014', 'V012', 'P014', 1, 18.00),
-- ('DV015', 'V013', 'P015', 1, 15.00),
-- ('DV016', 'V014', 'P001', 1, 29.99),
-- ('DV017', 'V015', 'P002', 1, 39.99),
-- ('DV018', 'V001', 'P003', 1, 15.50),
-- ('DV019', 'V002', 'P004', 1, 25.00),
-- ('DV020', 'V003', 'P005', 1, 12.99),
-- ('DV021', 'V004', 'P006', 1, 19.99),
-- ('DV022', 'V005', 'P007', 1, 10.50),
-- ('DV023', 'V006', 'P008', 1, 22.50),
-- ('DV024', 'V007', 'P009', 1, 7.50),
-- ('DV025', 'V008', 'P010', 1, 49.99);

/*------------------------------------------------
--------------------------------------------------
-- PROCEDIMIENTOS LISTAR
--------------------------------------------------
--------------------------------------------------*/

-- CLIENTES
DELIMITER //
CREATE PROCEDURE sp_ListarCliente()
BEGIN
    SELECT nombre, apellido, email, fecha_registro
    FROM tb_cliente;
END //
DELIMITER ;

-- PRODUCTOS
DELIMITER //
CREATE PROCEDURE sp_ListarProducto()
BEGIN
    SELECT p.nombre AS nombre_producto, 
           p.descripcion, 
           p.precio, 
           c.nombre AS categoria
    FROM tb_producto p
    JOIN tb_categoria c ON p.id_categoria_producto = c.id_categoria;
END //
DELIMITER ;


-- USUARIOS				MUESTRA TODOS LOS USUARIOS SI ES NULL O A ALGUNOS USUARIOS SI SE ESPECIFÍCA EL ID
DELIMITER //
CREATE PROCEDURE sp_ListarUsuarios(IN p_id_rol INT)
BEGIN
    SELECT u.nombre, 
           u.apellido, 
           u.email, 
           u.celular, 
           DATE(u.fecha_registro) AS fecha_registro, 
           r.nombre AS rol
    FROM tb_usuario u
    JOIN tb_rol r ON u.id_usuario_rol = r.id_rol
    WHERE (p_id_rol IS NULL OR u.id_usuario_rol = p_id_rol);
END //
DELIMITER ;

-- EJEMPLOS
-- CALL sp_ListarUsuarios(NULL);
-- CALL sp_ListarUsuarios('R01');


-- VENTA				MUESTRA TODAS LAS VENTAS REALIZADAS Y EL NOMBRE DEL VENDEDOR
DELIMITER //
CREATE PROCEDURE sp_ListarVentas()
BEGIN
    SELECT 
        CONCAT(c.nombre, ' ', c.apellido) AS nombre_cliente,
        CONCAT(u.nombre, ' ', u.apellido) AS nombre_vendedor,
        p.nombre AS nombre_producto,
        v.cantidad,
        DATE(v.fecha_venta) AS fecha_venta,
        m.nombre AS metodo_pago,
        v.total
    FROM 
        tb_venta v
    JOIN 
        tb_cliente c ON v.id_venta_cliente = c.id_cliente
    JOIN 
        tb_producto p ON v.id_venta_producto = p.id_producto
    JOIN 
        tb_usuario u ON v.id_venta_usuario = u.id_usuario
    JOIN 
        tb_metodo_pago m ON v.id_metodopago_venta = m.id_metodopago;
END //
DELIMITER ;


-- VENTA DETALLE       MUESTRA LAS VENTAS QUE SE REALIZARON A UN CLIENTE
DELIMITER //
CREATE PROCEDURE sp_ListarVentaDetalle(IN p_id_cliente INT)
BEGIN
    SELECT 
        v.id_venta,
        v.fecha_venta,
        p.nombre AS nombre_producto,
        dv.cantidad,
        dv.precio_unitario,
        (dv.cantidad * dv.precio_unitario) AS total
    FROM 
        tb_venta v
    JOIN 
        tb_detalle_venta dv ON v.id_venta = dv.id_venta
    JOIN 
        tb_producto p ON dv.id_producto = p.id_producto
    WHERE 
        v.id_venta_cliente = p_id_cliente;
END //
DELIMITER ;

-- EJEMPLOS 
-- call sp_ListarVentaDetalle("C001")

-- PRODUCTOXSEDE 	MUESTRA LOS PRODUCTOS DEPENDIENDO A QUE SEDE HACEMOS REFERENCIA
DELIMITER //
CREATE PROCEDURE sp_ListarProductoxSede(IN p_id_sede INT)
BEGIN
    SELECT 
        p.nombre AS nombre_producto,
        p.descripcion,
        p.precio,
        c.nombre AS categoria,
        sp.stock_disponible
    FROM 
        tb_sedeproducto sp
    JOIN 
        tb_producto p ON sp.id_producto = p.id_producto
    JOIN 
        tb_categoria c ON p.id_categoria_producto = c.id_categoria
    WHERE 
        sp.id_sede = p_id_sede;
END //
DELIMITER ;

-- EJEMPLOS
-- call sp_ListarProductoxSede("S001");


/*------------------------------------------------
--------------------------------------------------
-- PROCEDIMIENTOS CREAR
--------------------------------------------------
--------------------------------------------------*/

-- CLIENTE			CREA UN NUEVO CLIENTE

DELIMITER //
CREATE PROCEDURE sp_CrearCliente(
    IN p_nombre VARCHAR(50),
    IN p_apellido VARCHAR(50),
    IN p_email VARCHAR(50)
)
BEGIN
    INSERT INTO tb_cliente (nombre, apellido, email, fecha_registro)
    VALUES (p_nombre, p_apellido, p_email, NOW());
END //
DELIMITER ;

-- CALL sp_CrearCliente('Juan', 'Pérez', 'juan.perez@example.com');


-- PRODUCTO 		CREA UN NUEVO PRODUCTO
DELIMITER //
CREATE PROCEDURE sp_CrearProducto(
    IN p_nombre VARCHAR(100),
    IN p_descripcion TEXT,
    IN p_precio FLOAT,
    IN p_id_categoria_producto INT,
    IN p_imagen_url VARCHAR(255),
    IN p_id_sede INT,
    IN p_stock_disponible INT
)
BEGIN
    -- Declarar la variable para almacenar el último ID generado
    DECLARE last_id_producto INT;

    -- Insertar el nuevo producto en la tabla
    INSERT INTO tb_producto (nombre, descripcion, precio, id_categoria_producto, imagen_url) 
    VALUES (p_nombre, p_descripcion, p_precio, p_id_categoria_producto, p_imagen_url);

    -- Obtener el último id_producto generado automáticamente
    SET last_id_producto = LAST_INSERT_ID();

    -- Insertar en la tabla tb_sedeproducto
    INSERT INTO tb_sedeproducto (id_sede, id_producto, stock_disponible)
    VALUES (p_id_sede, last_id_producto, p_stock_disponible);
END //
DELIMITER ;

-- EJEMPLOS
-- CALL sp_CrearProducto('hola', 'holadescripcion', 29.99, 'C001', 'http://ejemplo.com/imagen.jpg', 'S001', 100);


-- USUARIO 			CREA UN NUEVO USUARIO Y ENCRIPTA SU CONTRASEÑA

DELIMITER //
CREATE PROCEDURE sp_CrearUsuario(
    IN p_nombre VARCHAR(50),
    IN p_apellido VARCHAR(50),
    IN p_email VARCHAR(50),
    IN p_celular INT,
    IN p_contraseña VARCHAR(100),
    IN p_id_usuario_rol INT
)
BEGIN
    -- Insertar el nuevo usuario en la tabla con la contraseña encriptada
    INSERT INTO tb_usuario (nombre, apellido, email, celular, contraseña, fecha_registro, id_usuario_rol)
    VALUES (p_nombre, p_apellido, p_email, p_celular, SHA2(p_contraseña, 256), NOW(), p_id_usuario_rol);
END //
DELIMITER ;

-- EJEMPLOS
-- CALL sp_CrearUsuario('Juan', 'Pérez', 'juan.perez@example.com', 987654321, 'contraseña_segura', 'R02');

