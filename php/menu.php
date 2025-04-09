<?php
require_once 'conexion.php';

class Negocio {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerNegocios() {
        $sql = "SELECT * FROM negocios";
        $result = $this->conn->query($sql);

        $negocios = [];
        while ($row = $result->fetch_assoc()) {
            $negocios[] = $row;
        }
        return $negocios;
    }
}
?>
