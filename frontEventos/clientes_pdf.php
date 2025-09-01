<?php
//require('fpdf/fpdf.php');
require('tabla_pdf.php');
define('FPDF_FONTPATH','fpdf/font/');
$mat=array();
class PDF extends PDF_Tabla
{

//Cabecera de pagina
function Header()
{
   $this->SetTitulo('Listado de Clientes');
   $this->cabecera();
    //Salto de linea
    $this->Ln(3);
	
   $this->Tabla();
}

//Pie de pagina
function Footer()
{
   $this->piepagina();
}//END Footer
function Tabla()
{
 //----------------se arma el reporte--------------------
        global $mat; //matriz para guardar los datos de la consulta
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
         $i=0;
         foreach($objeto as $reg)
         {
           $mat[$i]["nombres"]= $reg->nombres;
           $mat[$i]["apellidos"]=$reg->apellidos;
			  $mat[$i]["direccion"]=$reg->direccion;
			  $mat[$i]["telefono"]=$reg->telefono;
			  $mat[$i]["correo"]=$reg->correo;
			 $i++;
         }
         //Colores, ancho de linea y fuente en negrita--- --->Color Blanco
            $this->SetFillColor(255,255,255);
            $this->SetTextColor(0);
            $this->SetDrawColor(0,0,0);
            $this->SetLineWidth(.2);
            $this->SetFont('Arial','B',10);
            //;;;;;;;;;;;;;;;;;;;Cabecera ancho del texto del encabezado de la tabla;;;;;;;;;;;
          //Titulos de las columnas
            $cabecera=array('No','Nombres','Apellidos','Direccion','Telefono','Correo');
            $this->SetWidths(array(10,20,20,50,20,50)); // define el ancho de la columnas
            $this->SetFont('Arial','B',10);
            for($i=0;$i<count($cabecera);$i++)
        	   $this->Cell($this->widths[$i],5,$cabecera[$i],1,0,'J',1);
        	$this->Ln();
   }//end Tabla
}//end class

//Creacion del objeto de la clase heredada
$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
//Tabla con N filas y 2  columnas

 global $mat;
for($i=0;$i<count($mat);$i++)
   {
     $pdf->Row(array($i+1,$mat[$i]["nombres"],$mat[$i]["apellidos"],$mat[$i]["direccion"],
	  $mat[$i]["telefono"],$mat[$i]["correo"]));
   }
$pdf->Output();
?>
