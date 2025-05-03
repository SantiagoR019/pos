<?php

require __DIR__ . '/ticket/autoload.php'; // Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

// Configuración de la base de datos
$con = mysqli_connect('193.203.175.72', 'u666839190_YitUX', 'Buhos2025*', 'u666839190_TQFJW');
date_default_timezone_set('America/Bogota');

// Inicializa variables para mostrar en el HTML
$order_message = "NUEVO POS - ESPERANDO PEDIDO...";
$order_details = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (isset($data['id'])) {
        $order_id = intval($data['id']);

        $sql = "SELECT * FROM `wp_wc_orders` WHERE id = $order_id AND status = 'wc-completed'";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $crow = mysqli_fetch_assoc($result);
            $direccion = $crow['customer_note'];

            // Configuración de la impresora
            $nombre_impresora = "david2";
            $connector = new WindowsPrintConnector($nombre_impresora);
            $printer = new Printer($connector);

            // Imprime la orden
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setTextSize(2, 2);
            $printer->text("Orden #: " . $order_id . "\n");
            $printer->setTextSize(1, 1);
            $printer->text(date("Y-m-d H:i:s") . "\n");
            $printer->text("-----------------------------" . "\n");
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("CANTIDAD  PRODUCTO    PRECIO.\n");
            $printer->text("-----------------------------" . "\n");

            // Obtén los detalles de los productos
            $consulta2PR = "SELECT * FROM `wp_woocommerce_order_items` WHERE `order_id` = $order_id";
            $result1PR = mysqli_query($con, $consulta2PR);

            $order_details .= "<ul>";
            while ($crow1PR = mysqli_fetch_assoc($result1PR)) {
                $idcan = $crow1PR['order_item_id'];
                $nombredeproducto = $crow1PR['order_item_name'];

                $cantidad_query = "SELECT meta_value FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` = $idcan AND meta_key = '_qty'";
                $precio_query = "SELECT meta_value FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` = $idcan AND meta_key = '_line_total'";

                $cantidad_result = mysqli_query($con, $cantidad_query);
                $precio_result = mysqli_query($con, $precio_query);

                $cantidad = mysqli_fetch_assoc($cantidad_result)['meta_value'] ?? 0;
                $precio = mysqli_fetch_assoc($precio_result)['meta_value'] ?? 0;

                $printer->text(" $cantidad | $nombredeproducto | $$precio\n");

                // Agrega detalles al HTML
                $order_details .= "<li>$cantidad x $nombredeproducto - $$precio</li>";
            }
            $order_details .= "</ul>";

            // Imprime el total
            $ttot = "SELECT meta_value FROM `wp_wc_orders_meta` WHERE `order_id` = $order_id AND `meta_key` = '_pos_cash_amount_tendered'";
            $result1ttot = mysqli_query($con, $ttot);

            if ($row1ttot = mysqli_fetch_assoc($result1ttot)) {
                $total = $row1ttot['meta_value'];
                $printer->text("-----------------------------" . "\n");
                $printer->setJustification(Printer::JUSTIFY_CENTER);
                $nombre_format_francais = number_format($total, 2, ',', ' ');
                $printer->setTextSize(2, 2);
                $printer->text("TOTAL: $$nombre_format_francais\n");
                $printer->setTextSize(1, 1);

                // Agrega el total al HTML
                $order_details .= "<p><strong>Total: $$nombre_format_francais</strong></p>";
            }

            // Cierra la impresora
            $printer->cut();
            $printer->close();

            // Marca el pedido como impreso
            $update_query = "UPDATE `wp_wc_orders` SET impreso = '1' WHERE id = $order_id";
            mysqli_query($con, $update_query);

            // Redirige a la página de visualización del pedido
            header("Location: nuevoPedido.php?id=$order_id");
            exit;
        } else {
            $order_message = "Pedido no encontrado o no completado.";
        }
    } else {
        $order_message = "ID del pedido no proporcionado.";
    }
} else {
    $order_message = "Método no permitido.";
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
            <?php echo $order_message; ?>
        </h1>
        <div id="order-details">
            <?php echo $order_details; ?>
        </div>
    </section>
</body>
</html>
