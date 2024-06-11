-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-06-2024 a las 17:17:26
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
  `id_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `estado_actual` enum('aprobado','pedente','finalizado') NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `fecha_compra` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_entrega` date NOT NULL DEFAULT current_timestamp(),
  `codigo_inventario` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `departamento` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `financiera`
--

CREATE TABLE `financiera` (
  `id_transicion` int(11) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `cuenta_bancaria` char(50) DEFAULT NULL,
  `estado` enum('aprobado','pediente','finalizado') NOT NULL,
  `saldo` decimal(10,2) DEFAULT NULL,
  `tipo_transaccion` enum('venta','compra','transferencia','pago','honorarios') DEFAULT NULL,
  `fecha_transaccion` datetime NOT NULL DEFAULT current_timestamp(),
  `id_empleado` int(11) DEFAULT NULL
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
  `categoria_productos` varchar(150) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `codigo_barras` varchar(50) DEFAULT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `estado` enum('disponible','No disponible','agotado') NOT NULL,
  `id_producto` int(11) DEFAULT NULL,
  `id_proveedor` int(11) DEFAULT NULL,
  `fecha_adquisicion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_vencimiento` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(0, 'annnn', 50000.00, 'aprobado', 'CR 18 CL 1 MU CASA 1009', '<p>hola</p>\r\n', 0, 2024, 'jjjjjjjjjjjj', NULL, 'credito', '¿Quieres adoptar un perrito_ ¡Te decimos dónde!.jpeg', '2024-06-07 02:58:40', '2024-06-07'),
(0, 'viviaba', 5555555.00, 'aprobado', 'hhhhhh234', '<p>hola vamos ganando</p>\r\n', 0, 2024, 'hola', NULL, 'credito', '¿Quieres adoptar un perrito_ ¡Te decimos dónde!.jpeg', '2024-06-07 03:51:40', '2024-06-07');

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
  `imagen_producto` varchar(255) DEFAULT NULL,
  `codigo_barras` varchar(50) DEFAULT NULL,
  `estado` enum('Finalizado','En proceso','entregado') NOT NULL,
  `fecha_adquisicion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_vencimiento` date NOT NULL DEFAULT current_timestamp(),
  `id_proveedor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id_producto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `registro_administrativo`
--

CREATE TABLE `registro_administrativo` (
  `id_registro_administrativo` int(11) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `tipo_registro` enum('venta','compra','transferencia','pago','honorarios') DEFAULT NULL,
  `estado_registro` enum('en_progreso','completado','pendiente','rechazado') DEFAULT NULL,
  `observaciones` text NOT NULL,
  `responsable` varchar(150) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_empleado` int(11) DEFAULT NULL
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
-- Indices de la tabla `financiera`
--
ALTER TABLE `financiera`
  ADD PRIMARY KEY (`id_transicion`),
  ADD KEY `id_empleado` (`id_empleado`);

--
-- Indices de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  ADD PRIMARY KEY (`codigo_inventario`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD UNIQUE KEY `codigo_barras` (`codigo_barras`),
  ADD KEY `fk_proveedor` (`id_proveedor`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id_proveedor`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `registro_administrativo`
--
ALTER TABLE `registro_administrativo`
  ADD PRIMARY KEY (`id_registro_administrativo`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_empleado` (`id_empleado`);

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
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cola_mensajes`
--
ALTER TABLE `cola_mensajes`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `financiera`
--
ALTER TABLE `financiera`
  MODIFY `id_transicion` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `inventarios`
--
ALTER TABLE `inventarios`
  MODIFY `codigo_inventario` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id_proveedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `registro_administrativo`
--
ALTER TABLE `registro_administrativo`
  MODIFY `id_registro_administrativo` int(11) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`codigo_inventario`) REFERENCES `inventarios` (`codigo_inventario`),
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`id_proveedor`) REFERENCES `inventarios` (`id_proveedor`),
  ADD CONSTRAINT `compras_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `financiera`
--
ALTER TABLE `financiera`
  ADD CONSTRAINT `financiera_ibfk_1` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`);

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
-- Filtros para la tabla `registro_administrativo`
--
ALTER TABLE `registro_administrativo`
  ADD CONSTRAINT `registro_administrativo_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`),
  ADD CONSTRAINT `registro_administrativo_ibfk_2` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
