<?php
class CompraModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    
        if (!$this->conexion) {
            die("Conexión fallida: " . mysqli_connect_error());
        }
        
        if (!mysqli_select_db($this->conexion, 'sofware_erp')) {
            die("Selección de base de datos fallida: " . mysqli_error($this->conexion));
        }
    }


    public function insertarCompra($productos_comprados, $detalles_productos, $precio_unitario, $precio_compra, $total_compra, $estado_actual, $metodo_pago, $fecha_compra, $fecha_entrega, $id_proveedor, $id_usuario, $factura) {
        // Escapar los datos para evitar inyecciones SQL
        $productos_comprados = mysqli_real_escape_string($this->conexion, $productos_comprados);
        $detalles_productos = mysqli_real_escape_string($this->conexion, $detalles_productos);
        $precio_unitario = mysqli_real_escape_string($this->conexion, $precio_unitario);
        $precio_compra = mysqli_real_escape_string($this->conexion, $precio_compra);
        $total_compra = mysqli_real_escape_string($this->conexion, $total_compra);
        $estado_actual = mysqli_real_escape_string($this->conexion, $estado_actual);
        $metodo_pago = mysqli_real_escape_string($this->conexion, $metodo_pago);
        $fecha_compra = mysqli_real_escape_string($this->conexion, $fecha_compra);
        $fecha_entrega = mysqli_real_escape_string($this->conexion, $fecha_entrega);
        
        // Escapar variables numéricas
        $id_usuario = intval($id_usuario);
        $id_proveedor = intval($id_proveedor);
    
        // Verificar si el usuario existe antes de insertar el pedido
        $consulta_usuario = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
        $resultado_usuario = mysqli_query($this->conexion, $consulta_usuario);
        if (!$resultado_usuario || mysqli_num_rows($resultado_usuario) == 0) {
            // El usuario no existe, retorna falso o maneja el error adecuadamente
            return false;
        }
    
        // Verificar si el proveedor existe antes de insertar el pedido
        $consulta_proveedor = "SELECT * FROM proveedores WHERE id_proveedor = $id_proveedor";
        $resultado_proveedor = mysqli_query($this->conexion, $consulta_proveedor);
        if (!$resultado_proveedor || mysqli_num_rows($resultado_proveedor) == 0) {
            // El proveedor no existe, retorna falso o maneja el error adecuadamente
            return false;
        }
    
        // Procesar la imagen
        $nombreFactura = $this->procesarImagen($factura);
    
        // Preparar la consulta SQL
        $consulta = "INSERT INTO compras (productos_comprados, detalles_productos, precio_unitario, precio_compra, total_compra, estado_actual, metodo_pago, fecha_compra, fecha_entrega, id_proveedor, id_usuario, factura) VALUES ('$productos_comprados', '$detalles_productos', '$precio_unitario', '$precio_compra', '$total_compra', '$estado_actual', '$metodo_pago', '$fecha_compra', '$fecha_entrega', '$id_proveedor', '$id_usuario', '$nombreFactura')";
    
        // Ejecutar la consulta
        if (mysqli_query($this->conexion, $consulta)) {
            return true; // La inserción fue exitosa
        } else {
            // Hubo un error en la inserción, imprime el mensaje de error
            echo "Error al insertar el registro: " . mysqli_error($this->conexion);
            return false;
        }
    }
    
     
private function procesarImagen($imagen) {
    $destino = __DIR__ . '/../public/img/factura-compra/';
    $nombreImagen = basename($imagen['name']);
    $rutaImagen = $destino . $nombreImagen;
    move_uploaded_file($imagen['tmp_name'], $rutaImagen);
    return $nombreImagen;
}
}


      ?>


<?php
class CompraModel {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    
        if (!$this->conexion) {
            die("Conexión fallida: " . mysqli_connect_error());
        }
        
        if (!mysqli_select_db($this->conexion, 'sofware_erp')) {
            die("Selección de base de datos fallida: " . mysqli_error($this->conexion));
        }
    }


    public function insertarCompra($productos_comprados, $detalles_productos, $precio_unitario, $precio_compra, $total_compra, $estado_actual, $metodo_pago, $fecha_compra, $fecha_entrega, $id_proveedor, $id_usuario, $factura) {
        // Escapar los datos para evitar inyecciones SQL
        $productos_comprados = mysqli_real_escape_string($this->conexion, $productos_comprados);
        $detalles_productos = mysqli_real_escape_string($this->conexion, $detalles_productos);
        $precio_unitario = mysqli_real_escape_string($this->conexion, $precio_unitario);
        $precio_compra = mysqli_real_escape_string($this->conexion, $precio_compra);
        $total_compra = mysqli_real_escape_string($this->conexion, $total_compra);
        $estado_actual = mysqli_real_escape_string($this->conexion, $estado_actual);
        $metodo_pago = mysqli_real_escape_string($this->conexion, $metodo_pago);
        $fecha_compra = mysqli_real_escape_string($this->conexion, $fecha_compra);
        $fecha_entrega = mysqli_real_escape_string($this->conexion, $fecha_entrega);
        
        // Escapar variables numéricas
        $id_usuario = intval($id_usuario);
        $id_proveedor = intval($id_proveedor);
    
        // Verificar si el usuario existe antes de insertar el pedido
        $consulta_usuario = "SELECT * FROM usuarios WHERE id_usuario = $id_usuario";
        $resultado_usuario = mysqli_query($this->conexion, $consulta_usuario);
        if (!$resultado_usuario || mysqli_num_rows($resultado_usuario) == 0) {
            // El usuario no existe, retorna falso o maneja el error adecuadamente
            return false;
        }
    
        // Verificar si el proveedor existe antes de insertar el pedido
        $consulta_proveedor = "SELECT * FROM proveedores WHERE id_proveedor = $id_proveedor";
        $resultado_proveedor = mysqli_query($this->conexion, $consulta_proveedor);
        if (!$resultado_proveedor || mysqli_num_rows($resultado_proveedor) == 0) {
            // El proveedor no existe, retorna falso o maneja el error adecuadamente
            return false;
        }
    
        // Procesar la imagen
        $nombreFactura = $this->procesarImagen($factura);
    
        // Preparar la consulta SQL
        $consulta = "INSERT INTO compras (productos_comprados, detalles_productos, precio_unitario, precio_compra, total_compra, estado_actual, metodo_pago, fecha_compra, fecha_entrega, id_proveedor, id_usuario, factura) VALUES ('$productos_comprados', '$detalles_productos', '$precio_unitario', '$precio_compra', '$total_compra', '$estado_actual', '$metodo_pago', '$fecha_compra', '$fecha_entrega', '$id_proveedor', '$id_usuario', '$nombreFactura')";
    
        // Ejecutar la consulta
        if (mysqli_query($this->conexion, $consulta)) {
            return true; // La inserción fue exitosa
        } else {
            // Hubo un error en la inserción, imprime el mensaje de error
            echo "Error al insertar el registro: " . mysqli_error($this->conexion);
            return false;
        }
    }
    
     
private function procesarImagen($imagen) {
    $destino = __DIR__ . '/../public/img/factura-compra/';
    $nombreImagen = basename($imagen['name']);
    $rutaImagen = $destino . $nombreImagen;
    move_uploaded_file($imagen['tmp_name'], $rutaImagen);
    return $nombreImagen;
}
}


      ?>


</thead>
    <tbody>
    <?php      

$mysqli = new mysqli('localhost', 'root', '', 'sofware_erp');
$mysqli->set_charset("utf8");
if($mysqli->connect_error){
    die('Error en la conexion' . $mysqli->connect_error);
}

// Consulta utilizando MySQLi
$consulta = "SELECT * FROM  productos ORDER BY id_producto";
$resultados = $mysqli->query($consulta);


// Comprobación de errores en la ejecución de la consulta
if (!$resultados) {
    die("Error al ejecutar la consulta: " . $mysqli->error);
}

// Iterar sobre los resultados y mostrarlos
while ($producto= $resultados->fetch_assoc()) {
?>
    
    <tr>
    <td><?php echo htmlspecialchars($producto['id_producto']); ?></td>
    <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
    <td><?php echo htmlspecialchars($producto['precio']); ?></td>
    <td><?php echo htmlspecialchars($producto['estado']); ?></td>
    <td><?php echo htmlspecialchars($producto['descripcion_detallada']); ?></td>
    <td><?php echo htmlspecialchars($producto['fecha_adquisicion']); ?></td>
    <td><?php echo htmlspecialchars($producto['fecha_vencimiento']); ?></td>
    <td><?php echo htmlspecialchars($producto['id_proveedor']); ?></td>
    <td><?php echo htmlspecialchars($producto['código_unico_referencia']); ?></td>
    <td><?php echo htmlspecialchars($producto['marca']); ?></td>
 <td><?php echo htmlspecialchars($producto['dimensiones']); ?></td>
 <td><?php echo htmlspecialchars($producto['peso']); ?></td>
 <td><img src="../../public/img/Catalogo/<?php echo $producto['catalogo']; ?>" width="100" alt=""></td>
        

        <td>
              
                  <!-- Botón para editar -->  
                <a href="edit.php?da=3&lla=<?php echo $producto['id_producto']; ?>"  class="btn btn-custom-green btn-editar">
                <i class="fas fa-edit icon"></i> Editar

<!-- Botón de Borrar -->
<a href="#" class="btn btn-danger btn-borrar" onclick="borrarProducto(<?php echo $producto['id_producto']; ?>, '<?php echo $empleado['imagen']; ?>', '<?php echo $empleado['documentacion_archivo']; ?>')">
    <i class="fas fa-trash-alt"></i> Borrar
</a>

<script>
function borrarProducto(id,catalogo) {
    if (confirm('¿Está seguro de borrar el producto?')) {
        // Realizar una petición AJAX para borrar el pedido
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Éxito en la eliminación del producto
                    alert('Producto eliminado correctamente.');
                    // Recargar la página para reflejar los cambios
                    location.reload();
                } else {
                    // Error al eliminar el pedido
                    alert('Error al eliminar el producto.');
                }
            }
        };

        // Configurar la URL de la petición AJAX
        var url = 'delete.php?lla=' + encodeURIComponent(id) + 
                  '&imagen=' + encodeURIComponent(imagen) + 
                  '&documentacion_archivo=' + encodeURIComponent(documentacionArchivo);

        // Configurar la petición AJAX
        xhr.open('GET', url, true);
        // Enviar la petición
        xhr.send();
    }
}
</script>


</tr>
            <?php
        }

        // Cerrar la conexión
        $mysqli->close();
        ?>
    </tbody>
</table>



</body>
</html>