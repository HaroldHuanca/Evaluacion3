<?php
include 'conexion.php';

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

if ($accion == 'agregar') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $descuento = $_POST['descuento'];
    $stock = $_POST['stock'];

    $conexion->query("INSERT INTO productos (nombre, descripcion, precio, descuento, cantidad)
                      VALUES ('$nombre', '$descripcion', '$precio', '$descuento', '$stock')");
    header("Location: index.php");
    exit;
}

if ($accion == 'editar') {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $descuento = $_POST['descuento'];
    $stock = $_POST['stock'];

    $conexion->query("UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio',
                      descuento='$descuento', cantidad='$stock' WHERE id=$id");
    header("Location: index.php");
    exit;
}

if ($accion == 'eliminar') {
    $id = $_GET['id'] ?? $_POST['id'];
    $conexion->query("DELETE FROM productos WHERE id=$id");
    header("Location: index.php");
    exit;
}

if ($accion == 'listar') {
    $filtro_nombre = $_POST['filtro_nombre'] ?? '';
    $filtro_precio = $_POST['filtro_precio'] ?? '0';
    $orden = $_POST['orden'] ?? 'nombre';

    $query = "SELECT * FROM productos WHERE nombre LIKE '%$filtro_nombre%'";

    if ($filtro_precio == '1') $query .= " AND precio < 20";
    elseif ($filtro_precio == '2') $query .= " AND precio BETWEEN 20 AND 50";
    elseif ($filtro_precio == '3') $query .= " AND precio > 50";

    $query .= " ORDER BY $orden ASC";

    $resultado = $conexion->query($query);
    while ($row = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>{$row['nombre']}</td>
                <td>{$row['descripcion']}</td>
                <td>S/. {$row['precio']}</td>
                <td>{$row['descuento']}%</td>
                <td>{$row['cantidad']}</td>
                <td>
                    <button class='btnEditar' data-id='{$row['id']}'>✏️</button>
                    <button class='btnEliminar' data-id='{$row['id']}'>🗑️</button>
                </td>
              </tr>";
    }
}
?>
