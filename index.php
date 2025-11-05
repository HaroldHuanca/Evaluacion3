<?php 
include 'conexion.php';

// Consulta inicial para cargar productos
$query = "SELECT * FROM productos ORDER BY nombre ASC";
$productos = $conexion->query($query);

// Obtener filtros si se enviaron
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $filtro_nombre = $_POST['filtro_nombre'] ?? '';
    $filtro_precio = $_POST['filtro_precio'] ?? '0';
    $orden = $_POST['orden'] ?? 'nombre';

    $query = "SELECT * FROM productos WHERE nombre LIKE '%$filtro_nombre%'";

    if ($filtro_precio == '1') $query .= " AND precio < 20";
    elseif ($filtro_precio == '2') $query .= " AND precio BETWEEN 20 AND 50";
    elseif ($filtro_precio == '3') $query .= " AND precio > 50";

    $query .= " ORDER BY $orden ASC";
    $productos = $conexion->query($query);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Productos</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
  <main class="contenedor">
    <!-- ASIDE FILTROS -->
    <aside class="filtros">
      <h3>Filtros</h3>
      <form method="POST" action="">
        <input type="text" name="filtro_nombre" placeholder="Buscar por nombre..." 
               value="<?php echo $_POST['filtro_nombre'] ?? ''; ?>">
        <label>Rango de precios:</label>
        <select name="filtro_precio">
          <option value="0" <?php echo (isset($_POST['filtro_precio']) && $_POST['filtro_precio'] == '0') ? 'selected' : ''; ?>>Todos</option>
          <option value="1" <?php echo (isset($_POST['filtro_precio']) && $_POST['filtro_precio'] == '1') ? 'selected' : ''; ?>>Menor a S/.20</option>
          <option value="2" <?php echo (isset($_POST['filtro_precio']) && $_POST['filtro_precio'] == '2') ? 'selected' : ''; ?>>Entre S/.20 y S/.50</option>
          <option value="3" <?php echo (isset($_POST['filtro_precio']) && $_POST['filtro_precio'] == '3') ? 'selected' : ''; ?>>Mayor a S/.50</option>
        </select>

        <label>Ordenar por:</label>
        <select name="orden">
          <option value="nombre" <?php echo (isset($_POST['orden']) && $_POST['orden'] == 'nombre') ? 'selected' : ''; ?>>Nombre</option>
          <option value="precio" <?php echo (isset($_POST['orden']) && $_POST['orden'] == 'precio') ? 'selected' : ''; ?>>Precio</option>
        </select>
        <button type="submit">Aplicar Filtros</button>
      </form>
    </aside>

    <!-- FORMULARIO -->
    <section class="formulario">
      <h2>Registrar Producto</h2>
      <form method="POST" action="crud.php">
        <input type="hidden" name="accion" value="<?php echo isset($_GET['editar']) ? 'editar' : 'agregar'; ?>">
        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?? ''; ?>">
        <input type="text" name="nombre" placeholder="Nombre" required 
               value="<?php echo $_GET['nombre'] ?? ''; ?>">
        <textarea name="descripcion" placeholder="Descripción"><?php echo $_GET['descripcion'] ?? ''; ?></textarea>
        <input type="number" name="precio" placeholder="Precio" step="0.01" required 
               value="<?php echo $_GET['precio'] ?? ''; ?>">
        <input type="number" name="descuento" placeholder="Descuento (%)" required 
               value="<?php echo $_GET['descuento'] ?? '0'; ?>" min="0" max="100">
        <input type="number" name="stock" placeholder="Cantidad en stock" required 
               value="<?php echo $_GET['stock'] ?? '0'; ?>" min="0">
        <button type="submit"><?php echo isset($_GET['editar']) ? 'Actualizar' : 'Guardar'; ?></button>
      </form>
    </section>

    <!-- TABLA -->
    <section class="tabla">
      <h2>Lista de Productos</h2>
      <table border="1">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Descuento</th>
            <th>Stock</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="tablaProductos">
          <?php 
          if ($productos->num_rows > 0) {
              while($row = $productos->fetch_assoc()) {
                  echo "<tr>
                          <td>{$row['nombre']}</td>
                          <td>{$row['descripcion']}</td>
                          <td>S/. {$row['precio']}</td>
                          <td>{$row['descuento']}%</td>
                          <td>{$row['cantidad']}</td>
                          <td>
                              <a href='index.php?editar=1&id={$row['id']}&nombre=".urlencode($row['nombre'])."&descripcion=".urlencode($row['descripcion'])."&precio={$row['precio']}&descuento={$row['descuento']}&stock={$row['stock']}' class='btnEditar'>✏️</a>
                              <a href='crud.php?accion=eliminar&nombre={$row['nombre']}' onclick='return confirm(\"¿Estás seguro de eliminar este producto?\")'>🗑️</a>
                          </td>
                        </tr>";
              }
          } else {
              echo "<tr><td colspan='6'>No hay productos registrados</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </section>
  </main>
  <footer>
    <div style="margin: auto 0;">
        <p>INTEGRANTES:</p><br>
        <p>Harold Huanca Ccasa</p><br>
        <p>Jorge Salvador Rodrigo Chipa</p><br>
        <p>Aaron Ramirez Tisoc</p><br>
    </div>
  </footer>
</body>
</html>
