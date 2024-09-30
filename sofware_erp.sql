-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-07-2024 a las 16:31:26
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
(1, 'FORTALECIMIENTO DEL MANEJO DE HERRAMIENTAS CLAVES PARA EL MEJORAMIENTO EMPRESARIAL', 'mendez', 'cyennyviviana23@hotmail.com', '222222222223', '3154288231', 'MANZANA U CASA 16', 'Palmira, Valle Del Cauca, Colombia', 'aprobado', '763777000', 'colombia', '2024-07-09 19:32:01', '2024-07-11');

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
(2, 'Auriculares inalámbricos', 'ssssssssss', 555555.00, 55555555.00, 50000000.00, '', 'efectivo', '2024-07-24 05:15:58', '2024-07-23', 1, 1, 59, '3dc1d89a-96f1-4aed-a1c2-4e644ac61b0d.jpeg');

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
(4, 'jose vaxc', 'ingeniera de sistemas', '2024-07-16', 47.00, 1000000.00, 3000000.00, 'activo', 'valle_del_cauca', '222222222223', '3154288231', 'MANZANA U CASA 16', 'Palmira, Valle Del Cauca, Colombia', NULL, 'colombia', '2024-07-16 18:05:09', NULL, 'empleado_66969a35e61ee_imagen.jpg', 'empleado_66969a35e8435_documento.jpg', '<p>sssssssssssssssssssssss</p>\\r\\n'),
(6, 'jose vaxc', 'ingeniera de sistemas', '2024-07-16', 47.00, 1000000.00, 3000000.00, '', 'antioquia', '222222222223', '3154288231', 'MANZANA U CASA 16', 'Palmira, Valle Del Cauca, Colombia', NULL, 'colombia', '2024-07-16 18:31:28', NULL, 'empleado_6696a060a2bce_imagen.png', 'empleado_6696a060a887b_documento.png', '<p>siiiiiiiii conservar mi paz espiritual</p>\\r\\n'),
(7, 'jose vaxc', 'ingeniera de sistemas', '2024-07-16', 47.00, 1000000.00, 3000000.00, '', 'antioquia', '22222222228', '3154288231', 'MANZANA U CASA 16', 'Palmira, Valle Del Cauca, Colombia', NULL, 'colombia', '2024-07-16 18:33:14', NULL, 'empleado_6696a0ca2c89e_imagen.png', 'empleado_6696a0caae410_documento.png', '<p>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p>\\r\\n');

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
(1, 'Lavadora automática', 123456, 12235.00, 566332.00, 99999999.99, 99999999.99, 'producto 3', 'kkkkkkkkkkkkk', '12222222', 'colombia', 'disponible', 13, 1, '2022-07-14 00:00:00', '2024-07-11', '¿Quieres adoptar un perrito_ ¡Te decimos dónde!.jpeg');

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
(1, 'annnn', 50000.00, 'aprobado', 'CR 18 CL 1 MU CASA 1009', '<p>hola</p>\r\n', 123564, 9, '<p>jjjjjjjjjjjj</p>\r\n', 59, 'credito', 'Participate in a 30-Day Glow-Up Challenge.jpg', '2024-07-16 00:58:10', '2024-06-07');

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
(13, 'Lavadora automática', 500000.00, 123456, 'Electrodomésticos', 'Disponible', '2024-07-09 00:00:00', '2028-06-30', 1, '<p>que interesante video sobre desarollar personal</p>\r\n', '11.jpg', '2589745632'),
(14, 'Televisor LED', 55555555.00, 123, 'producto 1', 'Disponible', '2024-07-09 00:00:00', '0000-00-00', 1, '<p>sssssssssssssssssssssssssss</p>\r\n', '0da13c47-1c79-4c66-9560-29f0acb626eb.jpeg', '1111111111111');

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
(1, 'brimaniek', '3154288231', '3154288231', 'pruebast@gmail.com', 'producto 1', 'Pago anticipado', 'credito', '<p>fffffffffffffffffffffffffffffsi conserva tu paz</p>\r\n', '', NULL, 'self care aesthetic ideas self care trending 2023 march.jpg');

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
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `cola_mensajes`
--
ALTER TABLE `cola_mensajes`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `financieras`
--
ALTER TABLE `financieras`
  MODIFY `id_transaccion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  MODIFY `codigo_inventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id_proyecto` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `fk_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id_proveedor`);

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
