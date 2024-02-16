<?php
// Verificar si se recibe una solicitud POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se reciben datos en el cuerpo de la solicitud
    $postData = file_get_contents('php://input');
    if ($postData !== false) {
        // Decodificar los datos JSON recibidos
        $jsonData = json_decode($postData, true);
        if ($jsonData !== null && isset($jsonData['carritoCompra'])) {
            // Obtener el array 'carritoCompra'
            $carritoCompra = $jsonData['carritoCompra'];
            // Imprimir los datos recibidos para verificar si se recibieron correctamente
            print_r($carritoCompra);
        } else {
            echo "Error: No se recibieron datos válidos en el cuerpo de la solicitud.";
        }
    } else {
        echo "Error: No se recibieron datos en el cuerpo de la solicitud.";
    }
} else {
    echo "Error: No se recibió una solicitud POST.";
}
?>