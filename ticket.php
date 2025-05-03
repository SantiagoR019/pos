<?php

require __DIR__ . '/ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

/*
	Este ejemplo imprime un
	ticket de venta desde una impresora térmica
*/


/*
    Aquí, en lugar de "POS" (que es el nombre de mi impresora)
	escribe el nombre de la tuya. Recuerda que debes compartirla
	desde el panel de control
*/

$nombre_impresora = "PosSubaRedes1"; 


$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);

#Mando un numero de respuesta para saber que se conecto correctamente.
echo 1;
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
	$logo = EscposImage::load("geek.png", true);
	$printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->bitImage($logo);
}catch(Exception $e){/*No hacemos nada si hay error*/}





/*

$printer->text("\n"."Licorera Puerto Fierro" . "\n");
$printer->text("www.app.licorerapuertofierro.com" . "\n");
$printer->text("3196070489 - 6047856" . "\n");

$printer->text("-- DATOS DEL CLIENTE --" . "\n");
$printer->text("Enviar a: David Monroy" . "\n");
$printer->text("Enviar a: Cra 19 # 2 - 78" . "\n");
$printer->text("Tel: 3196070489" . "\n");
#La fecha también
date_default_timezone_set("America/Mexico_City");
$printer->text(date("Y-m-d H:i:s") . "\n");
$printer->text("-----------------------------" . "\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("CANTIDAD  PRODUCTO    PRECIO.\n");
$printer->text("-----------------------------"."\n");
/*
	Ahora vamos a imprimir los
	productos
	$printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->text("2 RON MEDELLIN DORADO 750 ML. BOTELLA || $53,000.00\n");
    $printer->text("2 RON MEDELLIN DORADO 750 ML. BOTELLA || $53,000.00\n");
    $printer->text("2 RON MEDELLIN DORADO 750 ML. BOTELLA || $53,000.00\n");
    $printer->text("2 RON MEDELLIN DORADO 750 ML. BOTELLA || $53,000.00\n");
    $printer->text("2 RON MEDELLIN DORADO 750 ML. BOTELLA || $53,000.00\n");
    $printer->text("2 RON MEDELLIN DORADO 750 ML. BOTELLA || $53,000.00\n");
    $printer->text("2 RON MEDELLIN DORADO 750 ML. BOTELLA || $53,000.00\n");
    $printer->text("2 RON MEDELLIN DORADO 750 ML. BOTELLA || $53,000.00\n");
/*
	Terminamos de imprimir
	los productos, ahora va el total

$printer->text("-----------------------------"."\n");
$printer->setJustification(Printer::JUSTIFY_RIGHT);
$printer->text("SUBTOTAL: $100.00\n");
$printer->text("IVA: $16.00\n");
$printer->text("TOTAL: $116.00\n");

*/
/*
	Podemos poner también un pie de página

$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("Muchas gracias por su compra\n");
$printer->text("www.app.licorerapuertofierro.com" . "\n");
*/


/*Alimentamos el papel 3 veces*/
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


?>