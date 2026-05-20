<?php

include("db.php");
$metodo = $_SERVER["REQUEST_METHOD"] ?? "";
$total_servicios = 0;
if ($metodo !== "POST") {
    exit;
}
if (!isset($_POST["servicios"]) || !is_array($_POST["servicios"]) || count($_POST["servicios"]) == 0) {
    echo json_encode([
        "error" => true,
        "mensaje" => "No se ha seleccionado ningún servicio"
    ]);
    exit;
}
$nombre = $_POST['nombre'] ?? '';
$apellidos = $_POST['apellidos'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$correo = $_POST['correo'] ?? '';

$regex_letras = "/^[A-Za-zÀ-ÿ\u00f1\u00d1' -]+$";
$regex_telefono = "^\+?[0-9\s\-\(\)]{7,20}$";

if (empty($nombre) || !preg_match($regex_letras, $nombre)) {
    echo json_encode([
        "error" => true,
        "mensaje" => "El nombre no cumple con el formato solicitado"
    ]);
    exit;
}

if (empty($apellidos) || !preg_match($regex_letras, $apellidos)) {
    echo json_encode([
        "error" => true,
        "mensaje" => "Los apellidos no cumplen con el formato solicitado"
    ]);
    exit;
}

if (empty($telefono) || !preg_match($regex_telefono, $telefono)) {
    echo json_encode([
        "error" => true,
        "mensaje" => "El telefono no cumple con el formato solicitado"
    ]);
    exit;
}

if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "error" => true,
        "mensaje" => "El correo no cumple con el formato solicitado"
    ]);
    exit;
}

$serviciosSeleccionados = $_POST["servicios"];
$id = array_map('intval', $serviciosSeleccionados);

if (count($id) == 0) {
    echo json_encode([
        "error" => true,
        "mensaje" => "No hay servicios válidos"
    ]);
    exit;
}

$placeholders = implode(',', array_fill(0, count($id), '?'));

$stmt = $conexion->prepare("
    SELECT SUM(precio) as total 
    FROM servicios 
    WHERE id IN ($placeholders)
    ");

$tipos = str_repeat('i', count($id));
$stmt->bind_param($tipos, ...$id);
$stmt->execute();
$res = $stmt->get_result();
$fila = $res->fetch_assoc();
$stmt->close();


$total_servicios = $fila["total"] ?? 0;

$stmt = $conexion->prepare("INSERT INTO clientes 
                            (nombre, apellidos, telefono, correo) 
                            VALUES (?, ?, ?, ?)");

if (!$stmt) {
    die("Error en prepare: " . $conexion->error);
}

$stmt->bind_param(
    "ssss",
    $nombre,
    $apellidos,
    $telefono,
    $correo
);

if (!$stmt->execute()) {
    echo json_encode([
        "error" => true,
        "message" => "Error al crear cliente"
    ]);
    exit;
}

$cliente_id = $conexion->insert_id;
$stmt->close();

$stmt = $conexion->prepare("
    INSERT INTO cliente_servicios (cliente_id, servicio_id)
    VALUES (?, ?)
    ");

foreach ($id as $id_cliente) {
    $stmt->bind_param("ii", $cliente_id, $id_cliente);
    if (!$stmt->execute()) {
        echo json_encode([
            "error" => true,
            "mensaje" => "Error al asignar servicios"
        ]);
        exit;
    }
}
$stmt->close();

echo json_encode([
    "error" => false,
    "total" => $total_servicios
]);
exit;
