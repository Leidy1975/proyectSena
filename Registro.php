<?php
require_once 'conexion.php';

class Usuario {
    private $conn;
    private $nombre;
    private $apellido;
    private $correo;
    private $direccion;
    private $celular;
    private $contraseña;
    private $estado;
    private $rol;


    public function __construct($conn) {
        if (!$conn || $conn->connect_error) {
            die("Conexión fallida en Usuario: " . $conn->connect_error);
        }
        $this->conn = $conn;
    }

    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setApellido($apellido) { $this->apellido = $apellido; }
    public function setCorreo($correo) { $this->correo = $correo; }
    public function setDireccion($direccion) { $this->direccion = $direccion; }
    public function setCelular($celular) { $this->celular = $celular; }
    public function setContraseña($contraseña) {
        if (!empty($contraseña)) {
            $this->contraseña = password_hash($contraseña, PASSWORD_BCRYPT);
        } else {
            throw new Exception("La contraseña no puede estar vacía.");
        }
    }

    public function setRol($rol) { $this->rol = $rol; }
    public function setEstado($estado) { $this->estado = $estado; }

    public function registrar() {
        $sql = "INSERT INTO usuarios (nombre, apellido, celular, direccion, correo, contraseña, estado, rol) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Error en prepare(): " . $this->conn->error);
        }

        $stmt->bind_param("ssssssss", 
            $this->nombre, 
            $this->apellido, 
            $this->celular,
            $this->direccion,
            $this->correo,
            $this->contraseña,
            $this->estado,
            $this->rol
        );

        if ($stmt->execute()) {
            echo "Registro exitoso.";
        } else {
            echo "Error en el registro: " . $stmt->error;
        }
    }
}

$conn = Conectar::conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $usuario = new Usuario($conn);
        $usuario->setNombre($_POST['nombre']);
        $usuario->setApellido($_POST['apellido']);
        $usuario->setCorreo($_POST['correo']);
        $usuario->setDireccion($_POST['direccion']);
        $usuario->setCelular($_POST['celular']);
        $usuario->setContraseña($_POST['password']);
        $usuario->setRol($_POST['rol']);
        $usuario->setEstado("Activo");
        $usuario->registrar();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>