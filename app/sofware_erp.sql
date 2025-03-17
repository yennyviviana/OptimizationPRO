-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-01-2025 a las 22:12:52
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sofware_erp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(255) DEFAULT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `documento_identidad` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `estado` varchar(100) DEFAULT NULL,
  `codigo_postal` varchar(20) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `apellido`, `email`, `documento_identidad`, `telefono`, `direccion`, `ciudad`, `estado`, `codigo_postal`, `pais`, `fecha_creacion`, `fecha_modificacion`) VALUES
(1, 'viviana', 'mendezz', 'cyennyviviana23@hotmail.com', '222222222223', '3154288231', 'MANZANA U CASA 16', 'Palmira, Valle Del Cauca, Colombia', 'colombia', '763777000', '', '2024-11-05 20:34:15', '2024-07-11'),
(2, 'Juan', 'Pérez', 'juan.perez@example.com', '12345678', '555-1234', 'Calle Falsa 123', 'Ciudad de México', 'CDMX', '01000', 'México', '2024-10-01 00:00:00', '2024-10-05'),
(4, 'Carlos', 'López', 'carlos.lopez@example.com', '11223344', '555-6789', 'Calle Central 500', 'Guadalajara', 'Jalisco', '44100', 'México', '2024-10-03 00:00:00', '2024-10-07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cola_mensajes`
--

CREATE TABLE `cola_mensajes` (
  `id_mensaje` int(11) NOT NULL,
  `contenido_mensaje` text DEFAULT NULL,
  `tipo_mensaje` varchar(150) DEFAULT NULL,
  `prioridad_mensaje` enum('baja','normal','alta') DEFAULT NULL,
  `estado_mensaje` enum('pendiente','enviado','recibido','leído','archivado') DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT current_timestamp(),
  `remitente` varchar(255) DEFAULT NULL,
  `destinatario` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id_compra` int(11) NOT NULL,
  `productos_comprados` varchar(255) NOT NULL,
  `detalles_productos` text NOT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `precio_compra` decimal(10,2) DEFAULT NULL,
  `total_compra` decimal(10,2) DEFAULT NULL,
  `estado_actual` enum('aprobado','pediente','finalizado') NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `fecha_compra` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_entrega` date NOT NULL DEFAULT current_timestamp(),
  `codigo_inventario` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `factura` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id_compra`, `productos_comprados`, `detalles_productos`, `precio_unitario`, `precio_compra`, `total_compra`, `estado_actual`, `metodo_pago`, `fecha_compra`, `fecha_entrega`, `codigo_inventario`, `id_proveedor`, `id_usuario`, `factura`) VALUES
(1, 'Auriculares inalámbricos', 'ssssssssss', 555555.00, 55555555.00, 50000000.00, '', 'efectivo', '2024-07-24 05:04:58', '2024-07-23', 1, 1, 59, '3dc1d89a-96f1-4aed-a1c2-4e644ac61b0d.jpeg'),
(3, 'Televisor LED', 'ssssssssss', 555555.00, 55555555.00, 50000000.00, 'aprobado', 'efectivo', '2024-11-05 20:30:33', '2024-10-29', 1, 1, 59, 'Captura de pantalla (214).png'),
(5, 'Televisor LED', 'ssssssssss', 555555.00, 55555555.00, 50000000.00, 'aprobado', 'efectivo', '2024-11-05 20:31:43', '2024-11-05', 1, 1, 59, 'Captura de pantalla (21).png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `nombre_completo` varchar(150) DEFAULT NULL,
  `cargo` varchar(100) DEFAULT NULL,
  `fecha_contratacion` date DEFAULT NULL,
  `numero_horas` decimal(8,2) DEFAULT NULL,
  `precio_hora` decimal(10,2) DEFAULT NULL,
  `salario` decimal(10,2) DEFAULT NULL,
  `estado` enum('activo','inactivo','en_licencia') DEFAULT NULL,
  `departamento` varchar(100) DEFAULT NULL,
  `documento_identidad` varchar(255) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `ciudad` varchar(100) DEFAULT NULL,
  `codigo_postal` varchar(20) DEFAULT NULL,
  `pais` varchar(100) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fecha_modificacion` datetime DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `documentacion_archivo` varchar(255) DEFAULT NULL,
  `descripcion_profesional` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `nombre_completo`, `cargo`, `fecha_contratacion`, `numero_horas`, `precio_hora`, `salario`, `estado`, `departamento`, `documento_identidad`, `telefono`, `direccion`, `ciudad`, `codigo_postal`, `pais`, `fecha_creacion`, `fecha_modificacion`, `imagen`, `documentacion_archivo`, `descripcion_profesional`) VALUES
(4, 'veolia', 'ingeniera de sistemas', '2024-11-05', 47.00, 1000000.00, 3000000.00, 'activo', 'valle_del_cauca', '222222222223', '3154288231', 'MANZANA U CASA 16', 'Palmira, Valle Del Cauca, Colombia', NULL, 'colombia', '2024-11-05 20:38:47', NULL, 'empleado_66969a35e61ee_imagen.jpg', 'empleado_66969a35e8435_documento.jpg', '<p>sssssssssssssssssssssss</p>\\r\\n'),
(6, 'jose vaxc', 'ingeniera de sistemas', '2024-07-16', 47.00, 1000000.00, 3000000.00, '', 'antioquia', '222222222223', '3154288231', 'MANZANA U CASA 16', 'Palmira, Valle Del Cauca, Colombia', NULL, 'colombia', '2024-07-16 18:31:28', NULL, 'empleado_6696a060a2bce_imagen.png', 'empleado_6696a060a887b_documento.png', '<p>siiiiiiiii conservar mi paz espiritual</p>\\r\\n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `notify_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`id`, `title`, `start`, `end`, `notify_at`) VALUES
(43, 'Evento de prueba 1', '2025-01-20 09:00:00', '2025-01-20 11:00:00', NULL),
(44, 'Evento de prueba 2', '2025-01-21 10:00:00', '2025-01-21 12:00:00', NULL),
(45, 'Evento de prueba 3', '2025-01-22 14:00:00', '2025-01-22 16:00:00', NULL),
(46, 'respeto', '2025-01-20 09:00:00', '2025-01-20 10:00:00', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `financieras`
--

CREATE TABLE `financieras` (
  `id_transaccion` int(11) NOT NULL,
  `fecha_transaccion` date NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `tipo_transaccion` enum('ingreso','egreso') NOT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `id_cliente` int(11) DEFAULT NULL,
  `id_pedido` int(11) DEFAULT NULL,
  `codigo_inventario` int(11) DEFAULT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `id_compra` int(11) DEFAULT NULL,
  `id_proyecto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `financieras`
--

INSERT INTO `financieras` (`id_transaccion`, `fecha_transaccion`, `monto`, `tipo_transaccion`, `descripcion`, `id_usuario`, `id_proveedor`, `id_cliente`, `id_pedido`, `codigo_inventario`, `id_producto`, `id_compra`, `id_proyecto`) VALUES
(15, '2024-11-06', 0.00, 'egreso', 'ffffffffffffffffff', 59, 4, 2, 7, 4, 15, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventarios`
--

CREATE TABLE `inventarios` (
  `codigo_inventario` int(11) NOT NULL,
  `nombre_producto` varchar(150) NOT NULL,
  `cantidad_stock` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) DEFAULT NULL,
  `costo_unitario` decimal(10,2) DEFAULT NULL,
  `precio_compra` decimal(10,2) DEFAULT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `categoria_productos` varchar(150) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `codigo_barras` varchar(150) DEFAULT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `estado` enum('disponible','No disponible','agotado') NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `fecha_adquisicion` datetime DEFAULT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `tipo_documento` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventarios`
--

INSERT INTO `inventarios` (`codigo_inventario`, `nombre_producto`, `cantidad_stock`, `precio_unitario`, `costo_unitario`, `precio_compra`, `precio_venta`, `categoria_productos`, `descripcion`, `codigo_barras`, `ubicacion`, `estado`, `id_producto`, `id_proveedor`, `fecha_adquisicion`, `fecha_vencimiento`, `tipo_documento`) VALUES
(4, 'Smartphone de última generación', 12, 2000.00, 2000.00, 3000000.00, 49000000.00, 'producto 6', 'kkkkkkk', '009123456', 'colombia', '', 15, 4, '2024-11-13 00:00:00', '2024-11-20', 'Captura de pantalla (228).png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `nombre_pedido` varchar(150) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `estado` enum('aprobado','cancelado','en stock','entregado') NOT NULL,
  `direccion` varchar(100) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `numero_seguimiento` int(11) NOT NULL,
  `tiempo_entrega_horas` int(11) NOT NULL,
  `informacion_pedido` text NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `archivo` varchar(255) DEFAULT NULL,
  `fecha_pedido` varchar(255) DEFAULT NULL,
  `fecha_entrega` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `nombre_pedido`, `precio`, `estado`, `direccion`, `descripcion`, `numero_seguimiento`, `tiempo_entrega_horas`, `informacion_pedido`, `id_usuario`, `metodo_pago`, `archivo`, `fecha_pedido`, `fecha_entrega`) VALUES
(5, 'Pedido A', 150.50, 'aprobado', 'Calle 123, Ciudad', '<p>Descripci&oacute;n del Pedido A</p>\r\n', 23, 2, '<p>Informaci&oacute;n adicional A</p>\r\n', 59, 'credito', '5.png', '2024-11-05 20:08:42', '2024-11-03'),
(6, 'Pedido B', 200.00, '', 'Av. Siempre Viva 742', 'Descripción del Pedido B', 0, 72, 'Información adicional B', 2, 'PayPal', 'archivoB.pdf', '2024-11-02', '2024-11-05'),
(7, 'Pedido C', 99.99, 'entregado', 'Carrera 45 #20-10', 'Descripción del Pedido C', 0, 24, 'Información adicional C', 3, 'Efectivo', 'archivoC.pdf', '2024-11-03', '2024-11-04'),
(8, 'Pedido D', 50.75, 'cancelado', 'Calle de los Cerezos 55', 'Descripción del Pedido D', 0, 36, 'Información adicional D', 4, 'Transferencia Bancaria', 'archivoD.pdf', '2024-11-04', '2024-11-06'),
(10, 'caja grande4', 66666666.00, 'aprobado', 'MANZANA U CASA 16', '<p>dddddddddddddddddddddddddddddddd</p>\r\n', 0, 0, 'ddddddddddddddddddd', 59, 'credito', '2.png', '2025-01-16 06:46:28', '2025-01-17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `nombre_producto` varchar(150) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `cantidad_stock` int(11) NOT NULL,
  `categoria_productos` varchar(150) NOT NULL,
  `estado` enum('Disponible','No disponible','En espera') NOT NULL,
  `fecha_adquisicion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_vencimiento` date NOT NULL DEFAULT current_timestamp(),
  `id_proveedor` int(11) DEFAULT NULL,
  `detalles` varchar(255) DEFAULT NULL,
  `archivo` varchar(255) NOT NULL,
  `codigo_barras` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre_producto`, `precio`, `cantidad_stock`, `categoria_productos`, `estado`, `fecha_adquisicion`, `fecha_vencimiento`, `id_proveedor`, `detalles`, `archivo`, `codigo_barras`) VALUES
(15, 'Lavadora automática', 400000.00, 123, 'producto 8', 'En espera', '2024-11-06 00:00:00', '0000-00-00', 4, '<p>estamos aqui.....pero confianza en Dios&nbsp; en mi MISMA sigue creciendo</p>\r\n', 'Captura de pantalla (236).png', '000012345678');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id_proveedor` int(11) NOT NULL,
  `nombre_empresa` varchar(150) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `telefono` varchar(150) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `lista_productos` varchar(150) NOT NULL,
  `condiciones_pago` enum('Pago anticipado','Pago a plazos','Pago contra entrega') DEFAULT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `historial_pedidos` varchar(255) NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `archivo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id_proveedor`, `nombre_empresa`, `direccion`, `telefono`, `correo_electronico`, `lista_productos`, `condiciones_pago`, `metodo_pago`, `descripcion`, `historial_pedidos`, `id_producto`, `archivo`) VALUES
(4, 'bibiC', 'manzana  X 200-100', '3154288231', 'yennyvivianannncaicedo23@hotmail.com', 'producto 1', 'Pago a plazos', 'transfarencia', '<p>HOLA VAMOS POR EXITO.</p>\r\n', '', NULL, 'Captura de pantalla (195).png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id_proyecto` int(11) NOT NULL,
  `nombre_proyecto` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `estado` enum('pendiente','en progreso','completado') NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `imagen_proyecto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id_proyecto`, `nombre_proyecto`, `descripcion`, `fecha_inicio`, `fecha_fin`, `estado`, `id_usuario`, `imagen_proyecto`) VALUES
(1, 'erp', 'si prioridad media', '2024-08-31', '2025-03-28', 'pendiente', 59, 'Captura de pantalla (229).png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(150) NOT NULL,
  `apellido_usuario` varchar(150) NOT NULL,
  `correo_electronico` varchar(255) NOT NULL,
  `contrasena` varchar(50) NOT NULL,
  `tipo_usuario` int(11) NOT NULL DEFAULT 3,
  `token_recuperacion` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `token_expiracion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre_usuario`, `apellido_usuario`, `correo_electronico`, `contrasena`, `tipo_usuario`, `token_recuperacion`, `token_expiracion`) VALUES
(59, 'Mabel', 'Meneses Grain', 'info@imsolucionesdigitales.com', '8cb2237d0679ca88db6464eac60da96345513964', 9, NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `cola_mensajes`
--
ALTER TABLE `cola_mensajes`
  ADD PRIMARY KEY (`id_mensaje`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `codigo_inventario` (`codigo_inventario`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `financieras`
--
ALTER TABLE `financieras`
  ADD PRIMARY KEY (`id_transaccion`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_proveedor` (`id_proveedor`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `codigo_inventario` (`codigo_inventario`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_compra` (`id_compra`),
  ADD KEY `fk_id_proyecto` (`id_proyecto`);

--
-- Indices de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD PRIMARY KEY (`codigo_inventario`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `fk_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id_proyecto`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `cola_mensajes`
--
ALTER TABLE `cola_mensajes`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `financieras`
--
ALTER TABLE `financieras`
  MODIFY `id_transaccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  MODIFY `codigo_inventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id_proyecto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `financieras`
--
ALTER TABLE `financieras`
  ADD CONSTRAINT `financieras_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `financieras_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`),
  ADD CONSTRAINT `financieras_ibfk_3` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `financieras_ibfk_4` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  ADD CONSTRAINT `financieras_ibfk_5` FOREIGN KEY (`codigo_inventario`) REFERENCES `inventarios` (`codigo_inventario`),
  ADD CONSTRAINT `financieras_ibfk_6` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `financieras_ibfk_7` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id_compra`),
  ADD CONSTRAINT `fk_id_proyecto` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`);

--
-- Filtros para la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD CONSTRAINT `inventarios_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `inventarios_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`) ON DELETE SET NULL;

--
-- Filtros para la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD CONSTRAINT `proveedores_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
