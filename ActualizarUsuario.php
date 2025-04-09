<?php
require_once 'conexion.php';
require_once 'clases.php';

// Obtener la lista de vehículos
try {
    $conexion = Conexion1::conectar();
    $sql = "SELECT id, nombre, apellido, celular, direccion, correo,  FROM usuarios"; // Consulta para obtener vehículos
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $vehiculos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error al obtener los vehículos: " . $e->getMessage();
}

// Procesar el formulario enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $marca = $_POST['marca'] ?? null;
    $modelo = $_POST['modelo'] ?? null;
    $tipo = $_POST['tipo'] ?? null;
    $distancia = $_POST['distancia'] ?? null;
    $costoPorKm = $_POST['costoPorKm'] ?? null;

    // Validar campos obligatorios
    if (empty($id) || empty($marca) || empty($modelo) || empty($tipo) || empty($distancia) || empty($costoPorKm)) {
        die("Todos los campos son obligatorios.");
    }

    try {
        // Crear la conexión
        $conexion = Conexion1::conectar();

        // Instanciar la clase correspondiente al tipo de vehículo
        switch ($tipo) {
            case 'moto':
                $vehiculo = new Moto($marca, $modelo, $distancia, $costoPorKm);
                break;
            case 'auto':
                $vehiculo = new Auto($marca, $modelo, $distancia, $costoPorKm);
                break;
            case 'camion':
                $vehiculo = new Camion($marca, $modelo, $distancia, $costoPorKm);
                break;
            default:
                throw new Exception("Tipo de vehículo no válido.");
        }

        // Llamar al método para actualizar el vehículo
        $vehiculo->ActualizarVehiculo($conexion, $id);
        echo "¡Vehículo actualizado exitosamente!";
    } catch (Exception $e) {
        echo "Error al actualizar el vehículo: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Vehículo</title>
</head>
<body>
    <h1>Actualizar Vehículo</h1>
    <form method="post">
        <label for="id">Selecciona el Vehículo:</label>
        <select name="id" id="id" required>
            <option value="">--Selecciona un Vehículo--</option>
            <?php foreach ($vehiculos as $vehiculo): ?>
                <option value="<?= $vehiculo['id']; ?>">
                    ID: <?= $vehiculo['id']; ?> - <?= $vehiculo['marca']; ?> <?= $vehiculo['modelo']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="tipo">Tipo de Vehículo:</label>
        <select name="tipo" id="tipo">
            <option value="moto">Moto</option>
            <option value="auto">Auto</option>
            <option value="camion">Camión</option>
        </select>
        <br><br>

        <label for="marca">Nueva Marca:</label>
        <input type="text" name="marca" id="marca" required>
        <br><br>

        <label for="modelo">Nuevo Modelo:</label>
        <input type="text" name="modelo" id="modelo" required>
        <br><br>

        <label for="distancia">Nueva Distancia (km):</label>
        <input type="number" name="distancia" id="distancia" required>
        <br><br>

        <label for="costoPorKm">Nuevo Costo por Km:</label>
        <input type="number" step="0.01" name="costoPorKm" id="costoPorKm" required>
        <br><br>

        <button type="submit">Actualizar</button>
    </form>
</body>
</html>
