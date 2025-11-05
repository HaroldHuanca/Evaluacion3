<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Productos</title>
<link rel="stylesheet" href="style.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
  <main class="contenedor">
    <!-- ASIDE FILTROS -->
    <aside class="filtros">
      <h3>Filtros</h3>
      <input type="text" id="filtro_nombre" placeholder="Buscar por nombre...">
      <label>Rango de precios:</label>
      <select id="filtro_precio">
        <option value="0">Todos</option>
        <option value="1">Menor a S/.20</option>
        <option value="2">Entre S/.20 y S/.50</option>
        <option value="3">Mayor a S/.50</option>
      </select>

      <label>Ordenar por:</label>
      <select id="orden">
        <option value="nombre">Nombre</option>
        <option value="precio">Precio</option>
      </select>
      <button id="btnFiltrar">Aplicar</button>
    </aside>

    <!-- FORMULARIO -->
    <section class="formulario">
      <h2>Registrar Producto</h2>
      <form id="formProducto">
        <input type="hidden" name="id" id="id">
        <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
        <textarea name="descripcion" id="descripcion" placeholder="Descripción"></textarea>
        <input type="number" name="precio" id="precio" placeholder="Precio" step="0.01" required>
        <input type="number" name="descuento" id="descuento" placeholder="Descuento (%)" required>
        <input type="number" name="stock" id="stock" placeholder="Cantidad en stock" required>
        <button type="submit">Guardar</button>
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
          <!-- Cargado por AJAX -->
        </tbody>
      </table>
    </section>
  </main>

<script src="script.js"></script>
</body>
</html>
