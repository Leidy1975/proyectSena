<?php
require_once 'conexion.php';

class Notificacion {
    private $conn;
    private $Destinatario;
    private $Asunto;
    private $Mensaje;
    private $Remitente;
    private $FechaCreacion;
    private $FechaRespuesta;

    public function __construct($conn) {
        if (!$conn || $conn->connect_error) {
            die("Error de conexión en Notificacion: " . $conn->connect_error);
        }
        $this->conn = $conn;
    }
    public function setDestinatario($Destinatario) { $this->Destinatario = $Destinatario; }
    public function getDestinatario() { return $this->Destinatario; }

    public function setAsunto($Asunto) { $this->Asunto = $Asunto; }
    public function getAsunto() { return $this->Asunto; }

    public function setMensaje($Mensaje) { $this->Mensaje = $Mensaje; }
    public function getMensaje() { return $this->Mensaje; }

    public function setRemitente($Remitente) { $this->Remitente = $Remitente; }
    public function getRemitente() { return $this->Remitente; }

    public function setFechaCreacion($FechaCreacion) { $this->FechaCreacion = $FechaCreacion; }
    public function getFechaCreacion() { return $this->FechaCreacion; }

    public function setFechaRespuesta($FechaRespuesta) { $this->FechaRespuesta = $FechaRespuesta; }
    public function getFechaRespuesta() { return $this->FechaRespuesta; }

    public function guardarNotificacion() {
        $sql = "INSERT INTO notificaciones (Destinatario, Asunto, Mensaje, Remitente, FechaCreacion, FechaRespuesta) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error al preparar la consulta: " . $this->conn->error);
        }

        $stmt->bind_param("ssssss", 
            $this->Destinatario, 
            $this->Asunto, 
            $this->Mensaje, 
            $this->Remitente, 
            $this->FechaCreacion, 
            $this->FechaRespuesta
        );

        return $stmt->execute();
    }
}
?>
