$(document).ready(function() {

  function listarProductos() {
    $.post('crud.php', {
      accion: 'listar',
      filtro_nombre: $('#filtro_nombre').val(),
      filtro_precio: $('#filtro_precio').val(),
      orden: $('#orden').val()
    }, function(data) {
      $('#tablaProductos').html(data);
    });
  }

  listarProductos();

  $('#btnFiltrar').on('click', listarProductos);

  $('#formProducto').on('submit', function(e) {
    e.preventDefault();
    const accion = $('#id').val() ? 'editar' : 'agregar';

    $.post('crud.php', $(this).serialize() + '&accion=' + accion, function() {
      $('#formProducto')[0].reset();
      $('#id').val('');
      listarProductos();
    });
  });

  $(document).on('click', '.btnEliminar', function() {
    if (confirm("¿Seguro que deseas eliminar este producto?")) {
      $.post('crud.php', {accion: 'eliminar', id: $(this).data('id')}, listarProductos);
    }
  });

  $(document).on('click', '.btnEditar', function() {
    const fila = $(this).closest('tr').children('td');
    $('#id').val($(this).data('id'));
    $('#nombre').val(fila.eq(0).text());
    $('#descripcion').val(fila.eq(1).text());
    $('#precio').val(fila.eq(2).text().replace('S/. ', ''));
    $('#descuento').val(fila.eq(3).text().replace('%', ''));
    $('#stock').val(fila.eq(4).text());
  });

});
