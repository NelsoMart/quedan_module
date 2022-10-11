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
    /* border: solid red; */
    min-height: 100vh;
 }

 .cant_letras{
    /* border: 1px solid darkblue; */
    width: 55%; /*lo largo */
    margin-top: 24%; /*para mover hacia arriba seria un numero mas y hacia abajo un numero menos*/
    /* margin-left: 13%; para mover del borde de izquierda */
    height: 20px; /* lo ancho*/

 }



 .cant_num{
  
   margin-left: 76%;
   width: 20%;
   margin-top: 1%;
   
   /* border: 1px solid yellow; */
   
 }

 .proveedor{
   /* border: 1px solid green; */
   width: 60%;
   margin-top: -8%;
   /* margin-left: 20%; */
   height: 40px;
 }


.fecha{
   /* border: 1px solid orange; */
   width: 15%;
   margin-top: -6%;
   margin-left: 37%;
}

.fuente{
   width: 45%;
   /* border: 1px solid red; */
   margin-top: -6%;
   margin-left: 55%;
}



/**estilos del cuadro de abajo */

.cant_letrasdos{
    /* border: 1px solid darkblue; */
    width: 55%; /*lo largo */
    margin-top: 15%; /* 19para mover hacia arriba seria un numero mas y hacia abajo un numero menos*/
    margin-left: 13%; /*para mover del borde de izquierda*/
    height: 40px; /* lo ancho*/

 }

 .cant_numdos{
  
  margin-left: 76%;
  width: 20%;
  margin-top: 2%;
  
  /* border: 1px solid yellow; */
  
}

.proveedordos{
   /* border: 1px solid green; */
   width: 50%;
   margin-top: -10%;
   margin-left: 20%;
   height: 40px;
 }

 .fechados{
   /* border: 1px solid orange; */
   width: 15%;
   margin-top: -7%;
   margin-left: 37%;
}

.fuentedos{
   width: 45%;
   /* border: 1px solid red; */
   margin-top: -7%;
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
   /* border: 1px solid black; */
   font-size: 8pt;
  
   display: inline-block;
 }

 .caja_inlinedos{
   margin-left: 50%;
   width: 10%;
   /* border: 1px solid black; */
   font-size: 6pt;
   
   display: inline-block;
 }

 .altura{
   height: 10%;
   margin-top: 2%;
 
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
            {{-- <div class="cant_letras" >{{$getQuedan->cant_letra}}</div> --}}
            <div class="cant_letras" >{{$NumConverted}}</div>
            <div class="cant_num">$    {{ number_format($getQuedan->cant_num, 2) }}</div>
         </div>
      <br>
      <br>
      <br>
      <div class="col-xs-12 col-md-3">
         <div class="proveedor">{{$getQuedan->nombre_proveedor}}</div>
   </div>
<br>
<br>

   <div class="col-xs-12 col-md-3">
      <div class="fecha">{{date("d/m/Y", strtotime($getQuedan->fecha_emi))}}</div>
      <div class="fuente">FUENTE DE FINANCIAMIENTO: {{$getQuedan->nombre_fuente}}</div>
   </div>

{{-- style="border: 1px solid green;" --}}
 <div  class="altura" > 
         {{-- style="border: 1px solid red; --}}
          <div class="col-xs-12 col-md-3" style="margin-top: -20px;">  <!--para mover los encabezados y primera columna -->
            <span class="caja_inline" style="margin-left: 5%;">FECHA FACTURA</span>
            {{-- <div class="caja_inline">FECHA RECEPCIÓN</div> --}}
            <span class="caja_inline">NO. FACTURA</span>
            <span class="caja_inline">VALOR FACTURA</span>
            
            <span class="caja_inline" style="margin-left: 20%;">FECHA FACTURA</span>
            {{-- <div class="caja_inline">FECHA RECEPCIÓN</div> --}}
            <span class="caja_inline">NO. FACTURA</span>
            <span class="caja_inline">VALOR FACTURA</span>
         </div>
 
  
 @php
   $count = 0;
 @endphp
 @foreach ($getFactura as $item)
         @break($count == 6)
      {{--  style="border: 1px solid blue;"  --}}
         <div >
            
              <div  class="caja_inline" style="margin-left: 5%; ">{{date("d/m/Y", strtotime($item->fecha_fac))}}</div>
              <div class="caja_inline" >{{$item->num_fac}}</div>
              <div class="caja_inline">{{$item->monto}}</div>

         </div>

         @php
         $count++;
         @endphp
 @endforeach

   
 </div>



   <div style="margin-top: -88px;"> <!--para mover de arriba hacia abajo o viceversa la segunda columna -->
   
      @foreach ($getFacturados as $item)
         {{-- style="border: 1px solid orange"  --}}
         <div >
            <div  class="caja_inline" style="margin-left: 57.5%;">{{date("d/m/Y", strtotime($item->fecha_fac))}}</div>
               <div class="caja_inline" >{{$item->num_fac}}</div>
               <div class="caja_inline">{{$item->monto}}</div>
         </div>
      

      
      @endforeach
   </div>

{{--  --}}
   <div  class="cuadrodos">
         
         <div class="container">
            <div class="col-xs-12 col-md-3">
               {{-- <div class="cant_letrasdos" >{{$getQuedan->cant_letra}}</div> --}}
               <div class="cant_letrasdos" >{{$NumConverted}}</div>
               <div class="cant_numdos">$    {{ number_format($getQuedan->cant_num, 2) }}</div>
         </div>
      <br>
      <br>
      <br>
      <div class="col-xs-12 col-md-3">
         <div class="proveedordos">{{$getQuedan->nombre_proveedor}}</div>
      </div>
      <br>
      <br>

      <div class="col-xs-12 col-md-3">
         <div class="fechados">{{date("d/m/Y", strtotime($getQuedan->fecha_emi))}}</div>
         <div class="fuentedos">FUENTE DE FINANCIAMIENTO: {{$getQuedan->nombre_fuente}}</div>
      </div>
   
      

   </div>

   <div>     
                                {{-- border: 1px solid red; --}}
      <div class="col-xs-12 col-md-3" style=" margin-top: -20px; " >
                  <span class="caja_inline" style="margin-left: 5%;">FECHA FACTURA</span>
                  <span class="caja_inline">NO. FACTURA</span>
                  <span class="caja_inline">VALOR FACTURA</span>
                  
                  <span class="caja_inline" style="margin-left: 20%;">FECHA FACTURA</span>
                  <span class="caja_inline">NO. FACTURA</span>
                  <span class="caja_inline">VALOR FACTURA</span>
      </div>
    
   @php
      $count = 0;
   @endphp
   @foreach ($getFactura as $item)
   @break($count == 6)
                        {{-- style="border: 1px solid blue; " --}}
            <div class="col-xs-6 col-md-3" >
               <div class="caja_inline" style="margin-left: 5%;">{{date("d/m/Y", strtotime($item->fecha_fac))}}</div>
               <div class="caja_inline">{{$item->num_fac}}</div>
               <div class="caja_inline">{{$item->monto}}</div>
         
            </div>
           
            @php
            $count++;
            @endphp
            @endforeach

<br>


                     {{-- border: 1px solid orange;  --}}
               <div style="margin-top:-107px; float:right ; width:100%;"  >

                  @foreach ($getFacturados as $item)

                     <div  >
                        <div  class="caja_inline" style="margin-left: 57.5%;">{{date("d/m/Y", strtotime($item->fecha_fac))}}</div>
                           <div class="caja_inline" >{{$item->num_fac}}</div>
                           <div class="caja_inline">{{$item->monto}}</div>
                     </div>



                  @endforeach 

               </div>
   </div>

  

</body>

</html>