<?php
include 'conexion.php';

/*ESTO ES EL EJEMPLO DE LA PROFEEEEEE*/


// Crear instancia de la conexión utilizando la clase Conexion1
$conexion = 'conexion'::conectar();

// Consultas para las distintas tablas
$sqlMoto = "SELECT v.marca, v.modelo, m.distancia, m.costoPorKm, (m.distancia * m.costoPorKm) AS costoTotal 
            FROM moto m 
            JOIN vehiculos v ON m.id = v.id";

$sqlAuto = "SELECT v.marca, v.modelo, a.distancia, a.costoPorKm, (a.distancia * a.costoPorKm) AS costoTotal 
            FROM auto a 
            JOIN vehiculos v ON a.id = v.id";

$sqlCamion = "SELECT v.marca, v.modelo, c.distancia, c.costoPorKm, (c.distancia * c.costoPorKm) AS costoTotal 
                FROM camion c 
                JOIN vehiculos v ON c.id = v.id";

// Generar el reporte
echo "<h1>Reporte de Costos por Ruta</h1>";

// Función para generar tablas
function generarTabla($conexion, $sql, $titulo) {
    echo "<h2>$titulo</h2>";
    $stmt = $conexion->prepare($sql);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($resultados)) {
        echo "<table border='1'>
                <tr><th>Marca</th><th>Modelo</th><th>Distancia (km)</th><th>Costo/Km</th><th>Costo Total</th></tr>";
        foreach ($resultados as $row) {
            echo "<tr>
                    <td>{$row['marca']}</td>
                    <td>{$row['modelo']}</td>
                    <td>{$row['distancia']}</td>
                    <td>{$row['costoPorKm']}</td>
                    <td>{$row['costoTotal']}</td>
                    </tr>";
        }
        echo "</table>";
    } else {
        echo "No hay datos disponibles.";
    }
}

// Mostrar motos
generarTabla($conexion, $sqlMoto, "Motos");

// Mostrar autos
generarTabla($conexion, $sqlAuto, "Autos");

// Mostrar camiones
generarTabla($conexion, $sqlCamion, "Camiones");
?>
