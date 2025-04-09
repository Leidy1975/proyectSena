<?php
require_once 'conexion.php';
session_start();

class IniciarSesion {
    private $conn;
    private $correo;
    private $contraseña;
    private $tipoUsuario;

    public function __construct($conn) {
        if (!$conn || $conn->connect_error) {
            die("Error de conexión en Login: " . $conn->connect_error);
        }
        $this->conn = $conn;
    }

    public function setCorreo($correo) {
        $this->correo = $correo;
    }

    public function setContraseña($contraseña) {
        $this->contraseña = $contraseña;
    }

    public function setTipoUsuario($tipoUsuario) {
        $this->tipoUsuario = $tipoUsuario;
    }

    public function autenticar() {
        $sql = "SELECT IdUsuario, Correo, Contraseña, Rol FROM usuarios WHERE Correo = ? AND Rol = ? AND Estado = 'Activo'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $this->correo, $this->tipoUsuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
            if (password_verify($this->contraseña, $usuario['Contraseña'])) {
                $_SESSION['id_usuario'] = $usuario['IdUsuario'];
                $_SESSION['correo'] = $usuario['Correo'];
                $_SESSION['rol'] = $usuario['Rol'];
                echo "Inicio de sesión exitoso. Bienvenido, " . $usuario['Rol'];

                header("Location: dashboard.php");
                exit();
            } else {
                echo "Contraseña incorrecta.";
            }
        } else {
            echo "Usuario no encontrado o inactivo.";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = new IniciarSesion($conn);
    $login->setCorreo($_POST['Correo']);
    $login->setContraseña($_POST['Password']);
    $login->setTipoUsuario($_POST['TipoUsuario']);
    $login->autenticar();
}
?>