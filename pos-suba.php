<?php

require __DIR__ . '/ticket/autoload.php'; // Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

// Configuración de la base de datos
$con = mysqli_connect('193.203.175.72', 'u666839190_YitUX', 'Buhos2025*', 'u666839190_TQFJW');
date_default_timezone_set('America/Bogota');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (isset($data['id'])) {
        $order_id = intval($data['id']);

        // Consulta para obtener el pedido
        $sql = "SELECT * FROM `wp_wc_orders` WHERE status='wc-completed' AND billing_email LIKE '%suba@buhosnocturnos.co%' and  impreso = '0'  ORDER BY ID desc";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $crow = mysqli_fetch_assoc($result);
            $direccion = $crow['customer_note'];
            $totalPedido = $crow['total_amount'];

            // Configuración de la impresora
            $nombre_impresora = "david2";
            $connector = new WindowsPrintConnector($nombre_impresora);
            $printer = new Printer($connector);


            # Vamos a alinear al centro lo próximo que imprimamos
            $printer->setJustification(Printer::JUSTIFY_CENTER);




            $ids = $crow['id'];
            $printer->setTextSize(2, 2);
            $printer->text("" . "\n");
            $printer->text("Orden #: " . $ids . "\n");
            $printer->setTextSize(1, 1);
            $printer->text("" . "\n");

            #La fecha también
            $printer->text(date("Y-m-d H:i:s") . "\n");
            $printer->text("-----------------------------" . "\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("CANTIDAD  PRODUCTO    PRECIO.\n");
            $printer->text("-----------------------------" . "\n");

            $consulta2PR = "SELECT * FROM `wp_woocommerce_order_items` WHERE `order_id` = " . $ids . "";
            $result1PR = mysqli_query($con, $consulta2PR);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            while ($crow1PR = mysqli_fetch_assoc($result1PR)) {
                $idcan = $crow1PR['order_item_id'];

                $preccant = "SELECT * FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` = " . $idcan . " AND meta_key = '_line_total'";
                $result1PRca = mysqli_query($con, $preccant);
                while ($crow1PRcant = mysqli_fetch_assoc($result1PRca)) {

                    $TOTAL = $crow1PRcant['meta_value'];
                    //$TOTAL = $crow1PRcant['meta_value']; 


                    $preccant = "SELECT * FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` = " . $idcan . " AND meta_key = '_QTY'";
                    $result1PRca = mysqli_query($con, $preccant);
                    while ($crow1PRcant = mysqli_fetch_assoc($result1PRca)) {

                        $nombredeproductoid = $crow1PRcant['meta_value'];
                        $nombredeproducto = $crow1PR['order_item_name'];
                        $printer->text(" " . $nombredeproductoid . " | " . $nombredeproducto . " | $" . $TOTAL . "\n");
                    }
                }

                $preccantsum = "SELECT * FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` = " . $idcan . " AND meta_key = '_line_total'";
                $result1PRcasum = mysqli_query($con, $preccantsum);
                $suma_total = 0;
            }

            $ttot = "SELECT total_amount FROM `wp_wc_orders` WHERE `id` = " . $ids . " ORDER BY id DESC";
            $result1ttot = mysqli_query($con, $ttot);
            while ($crow1ttot = mysqli_fetch_assoc($result1ttot)) {
                $idtts = $crow1ttot['total_amount'];
                $printer->text("-----------------------------" . "\n");
                $printer->setJustification(Printer::JUSTIFY_CENTER);

                $nombre_format_francais = number_format($idtts, 2, ',', ' ');
                $printer->setTextSize(2, 2);

                $printer->text("TOTAL: $" . $nombre_format_francais . "\n");
                $printer->setTextSize(1, 1);
            }

            $printer->text("" . "\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("-----------------------------" . "\n");
            $printer->text("DIRECCIÓN Y NUMERO DE CLIENTE \n");
            $printer->text("" . "\n");
            $printer->setTextSize(2, 2);
            $printer->text(utf8_encode($direccion) . "\n");
            $printer->setTextSize(1, 1);
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
            # Vamos a alinear al centro lo próximo que imprimamos

            $printer->setJustification(Printer::JUSTIFY_CENTER);
            // Imprime el logo
            try {
                $logo = EscposImage::load("logo-buho-nocturno.png", true);
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->bitImage($logo);
            } catch (Exception $e) {
                // No hacemos nada si hay error
            }

            $printer->text("\n");
            $printer->setTextSize(2, 2);
            $printer->text("Orden #: " . $order_id . "\n");
            $printer->setTextSize(1, 1);
            $printer->text("\n");
            $printer->text("-----------------------------\n");
            $printer->text("\nPUNTO SUBA\n");
            $printer->text("Licorera Buhos Nocturnos\n");
            $printer->text("www.buhosnocturnos.com\n");
            $printer->text("Gracias por tu Compra\n");
            $printer->text("(+57) 3022806868\n");
            $printer->text("\n");
            $printer->text("-----------------------------\n");

            // Imprime la fecha
            $printer->text(date("Y-m-d H:i:s") . "\n");
            $printer->text("-----------------------------\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("CANTIDAD  PRODUCTO    PRECIO\n");
            $printer->text("-----------------------------\n");

            // Obtén los detalles de los productos
            $consulta2PR = "SELECT * FROM `wp_woocommerce_order_items` WHERE `order_id` = $order_id";
            $result1PR = mysqli_query($con, $consulta2PR);

            while ($crow1PR = mysqli_fetch_assoc($result1PR)) {
                $idcan = $crow1PR['order_item_id'];
                $nombredeproducto = $crow1PR['order_item_name'];

                $cantidad_query = "SELECT meta_value FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` = $idcan AND meta_key = '_QTY'";
                $precio_query = "SELECT meta_value FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` = $idcan AND meta_key = '_line_total'";

                $cantidad_result = mysqli_query($con, $cantidad_query);
                $precio_result = mysqli_query($con, $precio_query);

                $cantidad = mysqli_fetch_assoc($cantidad_result)['meta_value'] ?? 0;
                $precio = mysqli_fetch_assoc($precio_result)['meta_value'] ?? 0;

                $printer->text(" $cantidad | $nombredeproducto | $$precio\n");
            }

            // Imprime el total
            $ttot = "SELECT total_amount FROM `wp_wc_orders` WHERE `id` = " . $ids . " ORDER BY id DESC";
            $result1ttot = mysqli_query($con, $ttot);
            while ($crow1ttot = mysqli_fetch_assoc($result1ttot)) {
                $idtts = $crow1ttot['total_amount'];
                $printer->text("-----------------------------" . "\n");
                $printer->setJustification(Printer::JUSTIFY_CENTER);

                $nombre_format_francais = number_format($idtts, 2, ',', ' ');
                $printer->setTextSize(2, 2);

                $printer->text("TOTAL: $" . $nombre_format_francais . "\n");
                $printer->setTextSize(1, 1);
            }

            // Imprime la dirección del cliente
            $printer->text("\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->text("-----------------------------\n");
            $printer->text("DIRECCIÓN Y NUMERO DE CLIENTE\n");
            $printer->text(utf8_encode($direccion) . "\n");
            $printer->text("-----------------------------\n");

            // Mensaje adicional
            $printer->text("!!!Con 10 Tiktes Iguales a este\n");
            $printer->text("Recibe una SixPack Gratis¡¡¡\n");
            $printer->text("Aplican Terminos y Condiciones\n");
            $printer->text("Siguenos en Facebook y Instagram\n");
            $printer->text("@licorerabuhosnocturnos\n");
            $printer->text("https://buhosnocturnos.co/\n");

            // Imprime QR opcional
            try {
                $qrr = EscposImage::load("qr_img.png", true);
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $printer->bitImage($qrr);
            } catch (Exception $e) {
                // No hacemos nada si hay error
            }

            // Finaliza la impresión
            $printer->feed(3);
            $printer->cut();
            $printer->pulse();
            $printer->close();

            // Marca el pedido como impreso
            $update_query = "UPDATE `wp_wc_orders` SET impreso = '1' WHERE id = $order_id";
            mysqli_query($con, $update_query);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido en Espera</title>
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
    </style>
</head>

<body>
    <section>
        <h1 id="order-status">
            <?php echo "NUEVO POS - ESPERANDO PEDIDO..."; ?>
        </h1>
        <div id="order-details">
            <?php echo ""; ?>
        </div>
    </section>
</body>

</html>