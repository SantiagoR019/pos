<style type="text/css">
    
    body {
    margin: 0;
    padding: 0;
    font-family: sans-serif;
    background-color: blue;
    text-align: center;
}
h1 {
    display: inline-block;
    margin-top: 50px;
    color: white;
    border-top: solid 5px white;
    border-bottom: solid 5px white;
    transform: skew(0, -5deg);
}
section {
     background-color: orangered;
}
#action {
    margin: 0 auto;
    width: 700px;
    position: relative;
    height: 300px;
   
}

#keg {
    position: absolute;
    height: 200px;    
    width: 70px;
    background-color: #656D78;
    border-right: solid 20px #434A54;
    bottom: 0;
    left: 310px;
}
#pipe {
    position: absolute;
    height: 30px;
    width: 10px;
    top: 30px;
    left: 10px;
    background-color: #CCD1D9;
}

#pipe:before {
    position: absolute;
    display: block;
    content: " ";
    height: 20px;
    width: 30px;
    top: -5px;
    left: 5px;
    background: linear-gradient(to bottom, #CCD1D9 50%, #AAB2BD 50%);
    border-radius: 0 10px 10px 0;
}

#pipe:after {
    position: absolute;
    display: block;
    content: " ";
    width: 10px;
    background-color: rgba(255, 206, 84, 0.5);
    
    animation: flow 5s ease infinite;
}

@keyframes flow {
    0%, 15% { 
        top: 30px;
        height: 0px;
    }
    20% { 
         height: 125px;
    }
    40% {        
        top: 30px;
        height: 85px;
    }
    55% {
        top: 30px;
        height: 60px;
    }
    60%, 100% {
        top: 70px;
        height: 0px;
    }
}

#pipe-front {
    position: absolute;
    height: 14px;
    width: 14px;
    top: 25px;
    left: 5px;
    background-color: #F5F7FA;
    border-radius: 10px;
    border: solid 3px #CCD1D9;
}

#pipe-handle {
    transform-origin: center bottom;
    position: absolute;
    width: 0;
    height: 5px;
    top: -20px;
    left: 5px;
    border-style: solid;
    border-width: 50px 10px 0 10px;
    border-color: black transparent transparent transparent;
    
    animation: handle 5s ease infinite;    
}
#pipe-handle:before {
    position: absolute;
    top: -60px;
    left: -10px;
    display: block;
    content: ' ';
    width: 20px;
    height: 10px;
    background-color: #CCD1D9;
    border-radius: 5px 5px 0 0;
}
#pipe-handle:after {
    position: absolute;
    top: -20px;
    left: -5px;
    display: block;
    content: ' ';
    width: 10px;
    height: 20px;
    background-color: #CCD1D9;
}
@keyframes handle {
    0%, 10% { 
       transform: rotate(0deg);
    }
    20%, 50% { 
         transform: rotate(-90deg);
    }
    60%, 100% {
        transform: rotate(0deg);
    }
}

.glass {    
    position: absolute;
    height: 100px;
    width: 70px;
    bottom: 0;
    background-color: rgba(255, 255, 255, 0.0);
    border-radius: 5px;
    
    animation: slide 5s ease forwards infinite;
}

@keyframes slide {
    0% { 
        opacity: 0;
        left: 0; 
    }
    20%, 80% { 
        opacity: 1;
        left: 300px; 
    }
    100% {
         opacity: 0;
        left: 600px;
    }
}

.front-glass {
    position: relative;
    height: 100%;
    width: 100%;
    background-color: rgba(255, 255, 255, 0.3);   
    border-radius: 5px;
}

.beer {
    position: absolute;
    bottom: 15px;
    margin: 0 5px;
    /*height: 80%;*/
    width: 60px;
    background-color: rgba(255, 206, 84, 0.8); /* #FFCE54*/
    border-radius: 0 0 5px 5px;
    border-top: solid 0px rgba(255, 206, 84, 0.8);
    
    animation: fillup 5s ease infinite;
}
.beer:after {
    position: absolute;
    display: block;
    content: " ";
    /*height: 20px;*/
    width: 100%;
    background-color: white;
    /*top: -20px;*/
    border-radius: 5px 5px 0 0;
    
    animation: fillupfoam 5s linear infinite, wave 0.5s alternate infinite;
}

.handle {
    position: absolute;
    right: -20px;
    top: 20px;
}
.handle .top-right {
    height: 20px;
    width: 10px;
    border-top: solid 10px rgba(255, 255, 255, 0.4);
    border-right: solid 10px rgba(255, 255, 255, 0.4);
    border-top-right-radius: 20px;
}
.handle .bottom-right {
    height: 20px;
    width: 10px;
    border-bottom: solid 10px rgba(255, 255, 255, 0.4);
    border-right: solid 10px rgba(255, 255, 255, 0.4);
    border-bottom-right-radius: 20px;
}

@keyframes fillup {
    0%, 20% { 
        height: 0px; 
        border-width: 0px;
    }
    40% {
        height: 40px; 
    }
    80%, 100% { 
        height: 80px; 
        border-width: 5px;
    }
}
@keyframes fillupfoam {
    0%, 20% { 
        top: 0px;
        height: 0px; 
    }
    60%, 100% { 
        top: -14px;
        height: 15px; 
    }
}
@keyframes wave {
    from { 
        transform: skew(0, -3deg);
    }
    to { 
        transform: skew(0, 3deg);
    }
}





</style>
<script type="text/javascript" src="https://leaverou.github.io/prefixfree/prefixfree.min.js"></script>

<section>
    <div id="action">
        <div id="keg">
            <div id="pipe-handle"></div>
            <div id="pipe"></div>       
            <div id="pipe-front"></div>
        </div>
    
        <div class="glass">
            <div class="beer"></div>
            <div class="handle">
                <div class="top-right"></div>
                <div class="bottom-right"></div>
            </div>
            <div class="front-glass"></div>
        </div>
    </div>
</section>
<center>
    <img src="https://buhosnocturnos.co/image/logoIzq.png" width="200">
</center>
<h1>
 NUEVO POS - ESPERANDO PEDIDO...
</h1>

<script type="text/javascript">
  setTimeout(function(){
    location = ''
  },30000)
</script>
<script src="jquery-3.1.1.min.js"></script>

<?php

require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


$con=mysqli_connect('193.203.175.72','u666839190_YitUX','Buhos2025*','u666839190_TQFJW');
//mysqli_connect("127.0.0.1", "mi_usuario", "mi_contraseña", "mi_bd");



date_default_timezone_set('America/Bogota');




//$sql = "SELECT * FROM wpc7_posts WHERE post_status = 'wc-completed' and  impe = '1' ORDER BY ID desc";
$sql = "SELECT * FROM `wp_wc_orders` WHERE status='wc-completed' and  impreso = '0' ORDER BY ID desc";
$result = mysqli_query($con, $sql);
while($crow = mysqli_fetch_assoc($result)) {
    $ids = $crow['id']; 
    $direccion = $crow['customer_note']; 

    //$consulta2 = "SELECT * FROM `wpc7_postmeta` WHERE `post_id` = ".$ids." AND `meta_value` = '         soledad@licoresbuhosnocturnos.com '";
    $consulta2 = "SELECT * FROM `wp_wc_orders_meta` WHERE `order_id` = ".$ids." AND `meta_value` LIKE '%buhosnocturnossur@gmail.com%'";
    $result1 = mysqli_query($con, $consulta2);
    while($crow1 = mysqli_fetch_assoc($result1)) {



$idg = $crow1['order_id']; 


$nombre_impresora = "david2"; 



$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);

#Mando un numero de respuesta para saber que se conecto correctamente.
/*
    Vamos a imprimir un logotipo
    opcional. Recuerda que esto
    no funcionará en todas las
    impresoras

    Pequeña nota: Es recomendable que la imagen no sea
    transparente (aunque sea png hay que quitar el canal alfa)
    y que tenga una resolución baja. En mi caso
    la imagen que uso es de 250 x 250
*/

# Vamos a alinear al centro lo próximo que imprimamos
$printer->setJustification(Printer::JUSTIFY_CENTER);


    

$ids = $crow['id']; 
$printer -> setTextSize(2, 2);
$printer->text("" . "\n");
$printer->text("Orden #: ".$ids."\n");
$printer -> setTextSize(1, 1);
$printer->text("" . "\n");

#La fecha también
$printer->text(date("Y-m-d H:i:s") . "\n");
$printer->text("-----------------------------" . "\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("CANTIDAD  PRODUCTO    PRECIO.\n");
$printer->text("-----------------------------"."\n");

    $consulta2PR = "SELECT * FROM `wp_woocommerce_order_items` WHERE `order_id` = ".$ids."";
    $result1PR = mysqli_query($con, $consulta2PR);
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    while($crow1PR = mysqli_fetch_assoc($result1PR)) {
    $idcan = $crow1PR['order_item_id']; 

    $preccant = "SELECT * FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` = ".$idcan." AND meta_key = '_line_total'";
    $result1PRca = mysqli_query($con, $preccant);
    while($crow1PRcant = mysqli_fetch_assoc($result1PRca)) {

            $TOTAL = $crow1PRcant['meta_value']; 
            //$TOTAL = $crow1PRcant['meta_value']; 

        
    $preccant = "SELECT * FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` = ".$idcan." AND meta_key = '_QTY'";
    $result1PRca = mysqli_query($con, $preccant);
    while($crow1PRcant = mysqli_fetch_assoc($result1PRca)) {

    $nombredeproductoid = $crow1PRcant['meta_value']; 
    $nombredeproducto = $crow1PR['order_item_name']; 
    $printer->text(" ".$nombredeproductoid." | ".$nombredeproducto." | $".$TOTAL."\n");

    }
}

        $preccantsum = "SELECT * FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` = ".$idcan." AND meta_key = '_line_total'";
    $result1PRcasum = mysqli_query($con, $preccantsum);     
$suma_total = 0;



    }

        $ttot = "SELECT * FROM `wp_wc_orders_meta` WHERE `order_id` = ".$ids." AND `meta_key` = '_pos_cash_amount_tendered'";
    $result1ttot = mysqli_query($con, $ttot);
    while($crow1ttot = mysqli_fetch_assoc($result1ttot)) {
     $idtts = $crow1ttot['meta_value']; 
     $printer->text("-----------------------------"."\n");
$printer->setJustification(Printer::JUSTIFY_CENTER);

$nombre_format_francais = number_format($idtts, 2, ',', ' ');
$printer -> setTextSize(2, 2);

$printer->text("TOTAL: $".$nombre_format_francais."\n");
$printer -> setTextSize(1, 1);

}
    
$printer->text("" . "\n");
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("-----------------------------"."\n");
$printer->text("DIRECCIÓN Y NUMERO DE CLIENTE \n");
$printer->text("" . "\n");
$printer -> setTextSize(2, 2);
$printer->text(utf8_encode($direccion). "\n");
$printer -> setTextSize(1, 1);
$printer->text("" . "\n");



/*
    Cortamos el papel. Si nuestra impresora
    no tiene soporte para ello, no generará
    ningún error
*/

$printer->cut();

/*
    Por medio de la impresora mandamos un pulso.
    Esto es útil cuando la tenemos conectada
    por ejemplo a un cajón
*/

$printer->pulse();

/*
    Para imprimir realmente, tenemos que "cerrar"
    la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
*/

$printer->close();

$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);

#Mando un numero de respuesta para saber que se conecto correctamente.
/*
    Vamos a imprimir un logotipo
    opcional. Recuerda que esto
    no funcionará en todas las
    impresoras

    Pequeña nota: Es recomendable que la imagen no sea
    transparente (aunque sea png hay que quitar el canal alfa)
    y que tenga una resolución baja. En mi caso
    la imagen que uso es de 250 x 250
*/

# Vamos a alinear al centro lo próximo que imprimamos

$printer->setJustification(Printer::JUSTIFY_CENTER);


try{
    $logo = EscposImage::load("logo-buho-nocturno.png", true);
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->bitImage($logo);
}catch(Exception $e){/*No hacemos nada si hay error*/}

$printer->text("" . "\n");

$ids = $crow['id']; 
$printer -> setTextSize(2, 2);
$printer->text("" . "\n");
$printer->text("Orden #: ".$ids."\n");
$printer -> setTextSize(1, 1);
$printer->text("" . "\n");

$printer->text("-----------------------------"."\n");
$printer->text("\n"."PUNTO SOLEDAD" . "\n");
$printer->text("\n"."Licorera Buhos Noctturnos" . "\n");
$printer->text("www.buhosnocturnos.com" . "\n");
$printer->text("Gracias por tu Compra" . "\n");
$printer->text("(+57) 3022806868" . "\n");
$printer->text("" . "\n");
$printer->text("-----------------------------"."\n");




#La fecha también
date_default_timezone_set("America/Mexico_City");
$printer->text(date("Y-m-d H:i:s") . "\n");
$printer->text("-----------------------------" . "\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("CANTIDAD  PRODUCTO    PRECIO.\n");
$printer->text("-----------------------------"."\n");

    $consulta2PR = "SELECT * FROM `wp_woocommerce_order_items` WHERE `order_id` = ".$ids."";
    $result1PR = mysqli_query($con, $consulta2PR);
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    while($crow1PR = mysqli_fetch_assoc($result1PR)) {
    $idcan = $crow1PR['order_item_id']; 

    $preccant = "SELECT * FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` = ".$idcan." AND meta_key = '_line_total'";
    $result1PRca = mysqli_query($con, $preccant);
    while($crow1PRcant = mysqli_fetch_assoc($result1PRca)) {

            $TOTAL = $crow1PRcant['meta_value']; 
            //$TOTAL = $crow1PRcant['meta_value']; 

        
    $preccant = "SELECT * FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` = ".$idcan." AND meta_key = '_QTY'";
    $result1PRca = mysqli_query($con, $preccant);
    while($crow1PRcant = mysqli_fetch_assoc($result1PRca)) {

    $nombredeproductoid = $crow1PRcant['meta_value']; 
    $nombredeproducto = $crow1PR['order_item_name']; 
    $printer->text(" ".$nombredeproductoid." | ".$nombredeproducto." | $".$TOTAL."\n");

    }
}

        $preccantsum = "SELECT * FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` = ".$idcan." AND meta_key = '_line_total'";
    $result1PRcasum = mysqli_query($con, $preccantsum);     
$suma_total = 0;



    }

        $ttot = "SELECT * FROM `wp_wc_orders_meta` WHERE `order_id` = ".$ids." AND `meta_key` = '_pos_cash_amount_tendered'";
    $result1ttot = mysqli_query($con, $ttot);
    while($crow1ttot = mysqli_fetch_assoc($result1ttot)) {
     $idtts = $crow1ttot['meta_value']; 
     $printer->text("-----------------------------"."\n");
$printer->setJustification(Printer::JUSTIFY_CENTER);

$nombre_format_francais = number_format($idtts, 2, ',', ' ');
$printer -> setTextSize(2, 2);

$printer->text("TOTAL: $".$nombre_format_francais."\n");
$printer -> setTextSize(1, 1);

}
    
$printer->text("" . "\n");
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("-----------------------------"."\n");
$printer->text("DIRECCIÓN Y NUMERO DE CLIENTE \n");
$printer->text("" . "\n");
$printer -> setTextSize(2, 2);
$printer->text(utf8_encode($direccion). "\n");
$printer -> setTextSize(1, 1);
$printer->text("" . "\n");



$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("!!!Con 10 Tiktes Iguales a este\n");
$printer->text("Recibe una SixPack Gratis¡¡¡\n");
$printer->text("Aplican Terminos y Condiciones\n");
$printer->text("Siguenos en Facebook y Instagram" . "\n");
$printer->text("@licorerabuhosnocturnos" . "\n");
$printer->text("https://buhosnocturnos.co/" . "\n");
$printer->text("" . "\n");



try{
   $qrr = EscposImage::load("qr_img.png", true);
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->bitImage($qrr);
}catch(Exception $e){/*No hacemos nada si hay error*/}
$printer->text("" . "\n");




$printer->feed(3);

/*
    Cortamos el papel. Si nuestra impresora
    no tiene soporte para ello, no generará
    ningún error
*/
$printer->cut();

/*
    Por medio de la impresora mandamos un pulso.
    Esto es útil cuando la tenemos conectada
    por ejemplo a un cajón
*/
$printer->pulse();

/*
    Para imprimir realmente, tenemos que "cerrar"
    la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
*/
$printer->close();



$sql = "UPDATE  wp_wc_orders set impreso  = '1' where  ID = ".$ids."";
        $result = mysqli_query($con, $sql);                 
        
}  } 

?>  