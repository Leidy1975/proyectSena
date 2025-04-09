<?php
require_once 'conexion.php';

class Negocio {
    private $conn;
    private $IdNegocios;
    private $NIT;
    private $Nombre;
    private $Direccion;
    private $Celular;
    private $Logo;
    private $Descripcion;
    private $Video;
    private $RedesSociales;
    private $FechaCreacion;
    private $IdUsuario;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function setDatos($data) {
        $this->NIT = $data['NIT'];
        $this->Nombre = $data['Nombre'];
        $this->Direccion = $data['Direccion'];
        $this->Celular = $data['Celular'];
        $this->Logo = $data['Logo'];
        $this->Descripcion = $data['Descripcion'];
        $this->Video = $data['Video'];
        $this->RedesSociales = $data['RedesSociales'];
        $this->FechaCreacion = $data['FechaCreacion'];
        $this->IdUsuario = $data['IdUsuario'];
    }

    public function guardarNegocio() {
        $sql = "INSERT INTO negocios (NIT, Nombre, Direccion, Celular, Logo, Descripcion, Video, RedesSociales, FechaCreacion, IdUsuario) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param(
            "sssssssssi",
            $this->NIT,
            $this->Nombre,
            $this->Direccion,
            $this->Celular,
            $this->Logo,
            $this->Descripcion,
            $this->Video,
            $this->RedesSociales,
            $this->FechaCreacion,
            $this->IdUsuario
        );

        return $stmt->execute();
    }

    public function actualizarNegocio($id) {
        $sql = "UPDATE negocios SET NIT = ?, Nombre = ?, Direccion = ?, Celular = ?, Logo = ?, Descripcion = ?, Video = ?, RedesSociales = ?, FechaCreacion = ?, IdUsuario = ? 
                WHERE IdNegocios = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param(
            "ssssssssiii",
            $this->NIT,
            $this->Nombre,
            $this->Direccion,
            $this->Celular,
            $this->Logo,
            $this->Descripcion,
            $this->Video,
            $this->RedesSociales,
            $this->FechaCreacion,
            $this->IdUsuario,
            $id
        );

        return $stmt->execute();
    }
}
?>
