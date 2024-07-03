<?php


class ProductoModel {
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



    public function insertarProducto($nombre_producto, $categoria_productos, $precio, $estado,  $detalles, $archivo,$id_proveedor) {
        // Escapar los datos para evitar inyecciones SQL
        $nombre_producto = mysqli_real_escape_string($this->conexion, $nombre_producto);
        $categoria_productos = mysqli_real_escape_string($this->conexion, $categoria_productos);
        $precio = mysqli_real_escape_string($this->conexion, $precio);
        $estado = mysqli_real_escape_string($this->conexion, $estado);
         $detalles = mysqli_real_escape_string($this->conexion, $detalles);
     
    
     // Verificar si el proveedor existe antes de insertar el producto
     $consulta_proveedor = "SELECT * FROM proveedores WHERE id_proveedor = '$id_proveedor'";
     $resultado_proveedor = mysqli_query($this->conexion, $consulta_proveedor);
     if (mysqli_num_rows($resultado_proveedor) == 0) {
         // El proveedor no existe, retorna falso
         return false;
     }
        // Procesar la imagen
        $nombreArchivo = $this->procesarImagen($archivo);

        // Preparar la consulta SQL
      echo  $consulta = "INSERT INTO productos (nombre_producto, categoria_productos, precio, estado, detalles,archivo,id_proveedor) VALUES ('$nombre_producto', '$categoria_productos', '$precio', '$estado', '$detalles','$nombreArchivo', '$id_proveedor')";

        // Ejecutar la consulta
        if (mysqli_query($this->conexion, $consulta)) {
            return true; // La inserción fue exitosa
        } else {
            return false; // Hubo un error en la inserción
        }
    }




    private function procesarImagen($imagen) {
        $destino = __DIR__ . '/../public/img/Catalogo/';
        $nombreImagen = basename($imagen['name']);
        $rutaImagen = $destino . $nombreImagen;
        move_uploaded_file($imagen['tmp_name'], $rutaImagen);
        return $nombreImagen;
    }


public function obtenerProveedores()
{
    

}

}


var_dump($_POST);


?>