<?php

// Configuración de la base de datos
$con = mysqli_connect('193.203.175.72', 'u666839190_YitUX', 'Buhos2025*', 'u666839190_TQFJW');
date_default_timezone_set('America/Bogota');

// Verifica si se recibió el ID del pedido
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Si es una solicitud AJAX, devuelve los datos en formato JSON
if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
    if ($order_id > 0) {
        $sql = "SELECT * FROM `wp_wc_orders` WHERE id = $order_id";
        $result = mysqli_query($con, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $crow = mysqli_fetch_assoc($result);
            $direccion = $crow['customer_note'];

            // Obtén los detalles de los productos
            $consulta2PR = "SELECT * FROM `wp_woocommerce_order_items` WHERE `order_id` = $order_id";
            $result1PR = mysqli_query($con, $consulta2PR);

            $order_details = [];
            while ($crow1PR = mysqli_fetch_assoc($result1PR)) {
                $idcan = $crow1PR['order_item_id'];
                $nombredeproducto = $crow1PR['order_item_name'];

                $cantidad_query = "SELECT meta_value FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` = $idcan AND meta_key = '_qty'";
                $precio_query = "SELECT meta_value FROM `wp_woocommerce_order_itemmeta` WHERE `order_item_id` = $idcan AND meta_key = '_line_total'";

                $cantidad_result = mysqli_query($con, $cantidad_query);
                $precio_result = mysqli_query($con, $precio_query);

                $cantidad = mysqli_fetch_assoc($cantidad_result)['meta_value'] ?? 0;
                $precio = mysqli_fetch_assoc($precio_result)['meta_value'] ?? 0;

                $order_details[] = [
                    'cantidad' => $cantidad,
                    'producto' => $nombredeproducto,
                    'precio' => $precio
                ];
            }

            // Obtén el total del pedido
            $ttot = "SELECT meta_value FROM `wp_wc_orders_meta` WHERE `order_id` = $order_id AND `meta_key` = '_pos_cash_amount_tendered'";
            $result1ttot = mysqli_query($con, $ttot);

            $total = 0;
            if ($row1ttot = mysqli_fetch_assoc($result1ttot)) {
                $total = $row1ttot['meta_value'];
            }

            // Respuesta JSON
            echo json_encode([
                'status' => 'success',
                'order_id' => $order_id,
                'direccion' => $direccion,
                'detalles' => $order_details,
                'total' => $total
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Pedido no encontrado.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID del pedido no proporcionado.']);
    }
    exit;
}

// Código HTML para mostrar el pedido
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Recibido</title>
    <script>
        // Función para consultar el servidor periódicamente
        function fetchOrder() {
            const orderId = <?php echo $order_id; ?>;
            if (orderId > 0) {
                fetch(`nuevoPedido.php?id=${orderId}&ajax=1`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            document.getElementById('order-id').innerText = data.order_id;
                            document.getElementById('direccion').innerText = data.direccion;

                            let detallesHtml = '';
                            data.detalles.forEach(item => {
                                detallesHtml += `<li>${item.cantidad} x ${item.producto} - $${item.precio}</li>`;
                            });
                            document.getElementById('order-details').innerHTML = detallesHtml;

                            document.getElementById('total').innerText = `$${data.total}`;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }

        // Actualiza cada 5 segundos
        setInterval(fetchOrder, 5000);
    </script>
</head>
<body>
    <h1>Pedido Recibido</h1>
    <p><strong>Orden #: </strong><span id="order-id">Cargando...</span></p>
    <p><strong>Dirección: </strong><span id="direccion">Cargando...</span></p>
    <h2>Detalles del Pedido:</h2>
    <ul id="order-details">
        <li>Cargando...</li>
    </ul>
    <p><strong>Total: </strong><span id="total">Cargando...</span></p>
</body>
</html>