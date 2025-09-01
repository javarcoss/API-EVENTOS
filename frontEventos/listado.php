<?php
$curl = curl_init();
curl_setopt_array($curl, array(
	CURLOPT_URL => "http://localhost/apieventos/getclientes.php",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
));

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);
if ($err) {
	echo "cURL Error #:" . $err;
    exit(1);
}
$objeto = json_decode($response);
?>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Nuevo Cliente</button>
<table class="table table-striped table-hover" id="tblcliente">
<thead>
    <th>ID</th>
    <th>NOMBRES</th>
    <th>TELEFONO</th>
    <th>CORREO</th>
    <th>ACCIONES</th>
</thead>
<tbody>
<?php
 foreach($objeto as $reg)
 {
  ?>
  <tr>
    <td> <?=$reg->id ?> </td>
    <td> <?=$reg->apellidos.' '.$reg->nombres ?> </td>
    <td> <?=$reg->telefono ?> </td>
    <td> <?=$reg->correo ?> </td>
    <td><button type="button" class="btn btn-danger" onclick="Eliminar(<?=$reg->id ?>);" >Eliminar</button>|
    <button type="button" class="btn btn-info" onclick="Editar(<?=$reg->id ?>);" >Editar</button></td>
  </tr> 
<?php   
 }
?>
</tbody>
<tfoot>
    <th>ID</th>
    <th>NOMBRES</th>
    <th>TELEFONO</th>
    <th>CORREO</th>
    <th>ACCIONES</th>
</tfoot>
</table>
<script>

  function Eliminar(idcliente)
  {
    if(confirm("¿Esta seguro que quieres eliminar el registro "+idcliente+" ?"))
    {

     var dato = {};
     dato.id=idcliente
     var datojson = JSON.stringify(dato);// {"id":5}
	$.ajax({
				type: "DELETE",
				url: 'http://localhost/apieventos/delete.php',
				data: datojson,
        contentType: "application/json; charset=UTF-8", // 👈 importante
        dataType: "json", // para que jQuery lo parsee
				
				success: function(response)
				{
					//var jsonData = JSON.parse(response);
					//console.log("Mensaje ",response['mensaje']);
          // alert(response['mensaje']+" Codigo: "+response['codigo']);
          //swal("Good job!", response['mensaje']+" Codigo: "+response['codigo'], "success");
          Swal.fire({
            title: "Eliminado",
            text: response['mensaje']+" Codigo: "+response['codigo'],
            icon: "success",
});
				   //location.reload();
					
			   }
		   });
	  }
    }
 
</script>


<script>
   $(document).ready( function () {
        $('#tblcliente').DataTable();
    } );
</script>

 
<?php
include('add.php');
include('edit.php');
?>	
<script>
   function Editar(idcliente)
   {
    $("#editar").modal("show");
   var parametros = {
    id: idcliente
   };

	$.ajax({
				type: "GET",
				url: "http://localhost/apieventos/getclientes.php",
				data: JSON.stringify(parametros),
        contentType: "application/json; charset=UTF-8", // 👈 importante
				dataType: "json",
				success: function(response)
				{
					//alert(response)
          $("#nombres").val(response['nombres']);
        },
 });
   }
   
</script> 