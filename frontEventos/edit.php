<div class="modal fade" id="editar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Cliente</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" name="formedit" id="formedit">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Nombres:</label>
            <input type="text" class="form-control" id="nombres" name="nombres" require>
          </div>

          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Apellidos:</label>
            <input type="text" class="form-control" id="apellidos" name="apellidos" require>
          </div>

          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" require>
          </div>

          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" require>
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">correo:</label>
            <input type="email" class="form-control" id="correo" name="correo" require>
          </div>
          
 <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>


        </form>
      </div>
     
    </div>
  </div>
</div>

<script>
    $('#formedit').submit(function(event)
 {
 
    var parametros = {
     nombres: $("#nombres").val(),
     apellidos: $("#apellidos").val(),
     correo: $("#correo").val(),
     telefono: $("#telefono").val(),
     direccion: $("#direccion").val()
    };
    var salida="";
         $.ajax({
                type: "POST",
                url: "http://localhost/apieventos/save.php",
                 data: JSON.stringify(parametros),
                 contentType: "application/json; charset=UTF-8", // 👈 importante
                 dataType: "json", // para que jQuery lo parsee
                success: function(response){
                Swal.fire({
                        title: "Creado",
                        text: response['mensaje']+" Codigo: "+response['codigo'],
                        icon: "success",
                });
                   
            }
        });
        event.preventDefault();
     
  }) 
</script>
