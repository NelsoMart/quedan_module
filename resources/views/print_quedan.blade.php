<!DOCTYPE html>
<html>

<head>
   <title>     QUEDAN</title>

  <!-- <link rel="stylesheet" href="estilos.css"/> -->

  <style>

   .body{
    font-family: Arial;
    font-size: 10pt;
    color:black;
    border: solid red;
 }

 .cant_letras{
    border: 1px solid darkblue;
    width: 55%;
    margin-top: 19%;
    margin-left: 13%;
    height: 40px;

 }

 .cant_num{
  
   margin-left: 76%;
   width: 20%;
   margin-top: -1%;
   
   border: 1px solid yellow;
   
 }

 .proveedor{
   border: 1px solid green;
   width: 50%;
   margin-top: -8%;
   margin-left: 20%;
   height: 40px;
 }


.fecha{
   border: 1px solid orange;
   width: 15%;
   margin-top: -5%;
   margin-left: 37%;
}

.fuente{
   width: 45%;
   border: 1px solid red;
   margin-top: -5%;
   margin-left: 55%;
}

 .two-fields {
width:800%;
}
.two-fields .input-group {
width:700%;
}
.two-fields input {
width:900% !important;
}

 .caja_inline {
   
   width: 10%;
   border: 1px solid black;
   font-size: 6pt;
  
   display: inline-block;
 }

 .caja_inlinedos{
   margin-left: 50%;
   width: 10%;
   border: 1px solid black;
   font-size: 6pt;
   
   display: inline-block;
 }

 .altura{
   height: 10%;
 
 }

 .cuadrodos{
   margin-top: 30%;
 }

 .dividir{
   column-count: 2;
   width: 50%;

   
 }
  </style>



</head>

<body class="body">
   
   <div class="container">
         <div class="col-xs-12 col-md-3">
            <div class="cant_letras" >{{$NumConverted}}</div>
            <div class="cant_num">$    {{$getQuedan->cant_num}}</div>
         </div>
<br>
<br>
<br>
<div class="col-xs-12 col-md-3">
   <div class="proveedor">Proveedor: {{$getQuedan->nombre_proveedor}}</div>
</div>
<br>
<br>

<div class="col-xs-12 col-md-3">
   <div class="fecha">{{date("d/m/Y", strtotime($getQuedan->fecha_emi))}}</div>
   <div class="fuente">FUENTE DE FINANCIAMIENTO: {{$getQuedan->nombre_fuente}}</div>
</div>


<div style="border: 1px solid green;" class="altura" >

         <div class="col-xs-12 col-md-3" style="border: 1px solid red;">
            <span class="caja_inline" style="margin-left: 5%;">FECHA FACTURA</span>
            {{-- <div class="caja_inline">FECHA RECEPCIÓN</div> --}}
            <span class="caja_inline">NO. FACTURA</span>
            <span class="caja_inline">VALOR FACTURA</span>
            
            <span class="caja_inline" style="margin-left: 20%;">FECHA FACTURA</span>
            {{-- <div class="caja_inline">FECHA RECEPCIÓN</div> --}}
            <span class="caja_inline">NO. FACTURA</span>
            <span class="caja_inline">VALOR FACTURA</span>
         </div>
 <br>
  
 @php
   $count = 0;
 @endphp
 @foreach ($getFactura as $item)
         @break($count == 6)
      
         <div class="col-xs-12 col-md-3" style="border: 1px solid blue;" class="dividir" >
            
              <div  class="caja_inline" style="margin-left: 5%;">{{date("d/m/Y", strtotime($item->fecha_fac))}}</div>
              <div class="caja_inline" >{{$item->num_fac}}</div>
              <div class="caja_inline">{{$item->monto}}</div>

         </div>

         @php
         $count++;
         @endphp
 @endforeach




     
</div>

<?php
   //  echo "<table border='1'><tr valign='top'><td>";

   //  for ($i=0;$i<=count($getFactura);$i++) {
   //  echo $getFactura[$i]."<br>";
   //  if ($i==count($getFactura)/2-1) {echo "</td><td>";}
   //  }

   //  echo "</tr></td>";
    ?>

<!-- <div style="margin-top: -70px;">
  
   @foreach ($getFacturados as $item)
    
      <div >
         <div  class="caja_inline" style="margin-left: 57%;">{{date("d/m/Y", strtotime($item->fecha_fac))}}</div>
            <div class="caja_inline" >{{$item->num_fac}}</div>
            <div class="caja_inline">{{$item->monto}}</div>
      </div>
   

    
   @endforeach
</div> -->


<div style="border: 1px solid black ;" class="cuadrodos">
      
<div class="container">
         <div class="col-xs-12 col-md-3">
            <div class="cant_letras" >{{$NumConverted}}</div>
            <div class="cant_num">$    {{$getQuedan->cant_num}}</div>
         </div>
<br>
<br>
<br>
<div class="col-xs-12 col-md-3">
   <div class="proveedor">Proveedor: {{$getQuedan->nombre_proveedor}}</div>
</div>
<br>
<br>

<div class="col-xs-12 col-md-3">
   <div class="fecha">{{date("d/m/Y", strtotime($getQuedan->fecha_emi))}}</div>
   <div class="fuente">FUENTE DE FINANCIAMIENTO: {{$getQuedan->nombre_fuente}}</div>
</div>


<div style="border: 1px solid green;" class="altura">

         <div class="col-xs-12 col-md-3" style="border: 1px solid red;">
            <span class="caja_inline" style="margin-left: 5%;">FECHA FACTURA</span>
            {{-- <div class="caja_inline">FECHA RECEPCIÓN</div> --}}
            <span class="caja_inline">NO. FACTURA</span>
            <span class="caja_inline">VALOR FACTURA</span>
            
            <span class="caja_inline" style="margin-left: 20%;">FECHA FACTURA</span>
            {{-- <div class="caja_inline">FECHA RECEPCIÓN</div> --}}
            <span class="caja_inline">NO. FACTURA</span>
            <span class="caja_inline">VALOR FACTURA</span>
         </div>
 <br>
 @php
   $count = 0;
 @endphp
 @foreach ($getFactura as $item)
 @break($count == 6)
         <div class="col-xs-12 col-md-3" style="border: 1px solid blue;" class="wrapper"  >
            
             <div class="caja_inline" style="margin-left: 5%;">{{date("d/m/Y", strtotime($item->fecha_fac))}}</div>
            <div class="caja_inline">{{$item->num_fac}}</div>
            <div class="caja_inline">{{$item->monto}}</div>
         </div>
         @php
         $count++;
         @endphp
         @endforeach

        

    
   <div style="clear:both"></div>
</div>



</div>


</body>

</html>