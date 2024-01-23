

<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "integrador_sexto";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recibir datos de PayPal
$detalles = file_get_contents("php://input");

// Convertir los datos JSON a un array asociativo
$detalles_array = json_decode($detalles, true);

// Extraer información relevante
$transaccion_id = $detalles_array['id'];
$fecha = date('Y-m-d H:i:s'); // Fecha actual
$status = $detalles_array['status'];
$email = $detalles_array['payer']['email_address'];
$id_cliente = 15; // Aquí deberías obtener el ID del cliente de donde corresponda
$monto_total = $detalles_array['purchase_units'][0]['amount']['value'];
// Añade o ajusta los campos adicionales según sea necesario

// Preparar la consulta SQL
$sql = "INSERT INTO productospago (id_transaccion, fecha, status, email, id_cliente, total) 
        VALUES ('$transaccion_id', '$fecha', '$status', '$email', '$id_cliente', '$monto_total')";
// Asegúrate de que los nombres de los campos coincidan con los de tu base de datos

// Ejecutar la consulta
if ($conn->query($sql) === TRUE) {
    echo "Detalles de la transacción guardados exitosamente.";
} else {
    echo "Error al guardar detalles: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>

