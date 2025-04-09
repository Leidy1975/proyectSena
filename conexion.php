<?php
class Conectar {
    public static function conectar() {
        $host = "localhost";
        $user = "root";
        $pass = "";
        $db = "empluc";

        $conexion = new mysqli($host, $user, $pass, $db);

        if ($conexion->connect_error) {
            die("Conexión fallida: " . $conexion->connect_error);
        }

        return $conexion;
    }
}
?>

