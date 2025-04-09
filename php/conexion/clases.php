<?php
require 'conexion.php';
abstract class RegistrarUsuario {
    protected $nombre;
    protected $apellido;
    protected $celular;
    protected $direccion;
    protected $correo;
    protected $contraseña;
    protected $estadoestado;
    protected $rol;



    public function __construct($nombre, $apellido, $celular, $direccion, $correo, $contraseña, $estado, $rol) {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->celular = $celular;
        $this->direccion = $direccion;
        $this->correo = $correo;
        $this->contraseña = $contraseña;
        $this->estado = $estado;
        $this->rol = $rol;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellido() {
        return $this->apellido;
    }

    public function setApellido($apellido) {
        $this->apellido = $apellido;
    }

    public function getCelular() {
        return $this->celular;
    }

    public function setCelular($celular) {
        $this->celular = $celular;
    }

    public function getDireccion() {
        return $this->direccion;
    }

    public function setDireccion($direccion) {
        $this->direccion= $direccion;
    }
    
    public function getCorreo() {
        return $this->correo;
    }

    public function setCorreo($correo) {
        $this->correo= $correo;
    }
    
    public function getContraseña() {
        return $this->contraseña;
    }

    public function setContraseña($contraseña) {
        $this->contraseña= $contraseña;
    }
    public function getEstado() {
        return $this->estado;
    }
    public function setEstado($estado) {
        $this->estado= $estado;
    }
    public function getRol() {
        return $this->rol;
    }
    public function setRol($rol) {
        $this->rol= $rol;
    }
    abstract public function conectar($conexion);
    abstract public function ActualizarUsuario($conexion, $id);

    //abstract public function borrarUsuario($conexion, $id);
}

class User extends usuario {
    //public $conexion= Conexion1::conectar();
    public function conectar($conexion): void {
        $sql = "INSERT INTO Usuario (explorador, emprendedor, administrador tipo) VALUES (?, ?, 'explorador')";
        $conexion = 'conexion'::conectar();
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $this->Explorador, PDO::PARAM_STR); // Cambia bind_param por bindUsuario
        $stmt->bindValue(2, $this->Emprendedor, PDO::PARAM_STR);
        $stmt->bindValue(2, $this->Administrador, PDO::PARAM_STR);
        $stmt->execute();
        $id = $conexion->lastInsertId();


        $sqlNegocios = "INSERT INTO Negocios (Nit, Logo, Descripcion, Video, RedesSociales, fechaCreacion) VALUES (?, ?, ?)";
        $stmtNegocios = $conexion->prepare($sqlNegocios);
        $stmtNegocios->bindValue(1, $id, PDO::PARAM_INT); 
        $stmtNegocios->bindValue(2, $this->Nit, PDO::PARAM_STR); // Cambia bind_param por bindUsuario
        $stmtNegocios->bindValue(3, $this->Logo, PDO::PARAM_STR);
        $stmtNegocios->bindValue(4, $this->Descripcion, PDO::PARAM_STR); // Cambia bind_param por bindUsuario
        $stmtNegocios->bindValue(5, $this->Video, PDO::PARAM_STR);
        $stmtNegocios->bindValue(6, $this->RedesSociales, PDO::PARAM_STR);
        $stmtNegocios->bindValue(7, $this->fechaCreacion, PDO::PARAM_STR);
        $stmtNegocios->execute();
    }

    public function ActualizarUsuario($conexion, $id): void {
        // Actualización específica para Moto
        $sqlUsuario = "UPDATE usuario SET nombre = ?, apellido = ?, celular = ?, direccion = ?, correo = ?, contraseña = ?, estado = ?, rol = ? WHERE id = ?";
        $stmtUsuario = $conexion->prepare($sqlUsuario);
        $stmtUsuario->execute([$this->nombre, $this->apellido, $this->celular, $this->direccion, $this->correo, $this->contraseña, $this->estado, $this->rol, $id]);

        $sqlNegocios = "UPDATE NegociosSET Nit = ?, Logo = ?, Descripcion = ?, Video = ?, RedesSociales = ?, fechaCreacion = ?, WHERE id = ?";
        $stmtNegocios = $conexion->prepare($sqlNegocios);
        $stmtNegocios->execute([$this->Nit, $this->Logo, $this->Descripcion, $this->Video, $this->RedesSociales, $this->fechaCreacion, $id]);
    }

    public function borrarUsuario($conexion, $id) {
        try {
            // Iniciar transacción
            $conexion->beginTransaction();

            // Eliminar de la tabla específica
            $sqlEspecifico = "DELETE FROM usuario WHERE id = ?";
            $stmtEspecifico = $conexion->prepare($sqlEspecifico);
            $stmtEspecifico->execute([$id]);

            // Eliminar de la tabla general
            $sqlGeneral = "DELETE FROM usuario WHERE id = ?";
            $stmtGeneral = $conexion->prepare($sqlGeneral);
            $stmtGeneral->execute([$id]);

            // Confirmar transacción
            $conexion->commit();
            echo "¡Usuario borrado exitosamente!";
        } catch (Exception $e) {
            // Revertir transacción si algo falla
            $conexion->rollBack();
            echo "Error al borrar el usuario: " . $e->getMessage();
        }
    }


}

class Auto extends Vehiculo {
    public function conectar($conexion): void {
        $sql = "INSERT INTO vehiculos (marca, modelo, tipo) VALUES (?, ?, 'auto')";
        $conexion = 'conexion'::conectar();
        $stmt = $conexion->prepare($sql);
        
        $stmt->bindValue(1, $this->marca, PDO::PARAM_STR); // Cambia bind_param por bindValue
        $stmt->bindValue(2, $this->modelo, PDO::PARAM_STR);
        $stmt->execute();
        $id = $conexion->lastInsertId();


        $sqlAuto = "INSERT INTO auto (id, distancia, costoPorKm) VALUES (?, ?, ?)";
        $stmtAuto = $conexion->prepare($sqlAuto);
        $stmtAuto->bindValue(1, $id, PDO::PARAM_INT); 
        $stmtAuto->bindValue(2, $this->distancia, PDO::PARAM_STR); // Cambia bind_param por bindValue
        $stmtAuto->bindValue(3, $this->costoPorKm, PDO::PARAM_STR);
        $stmtAuto->execute();
    }
    public function ActualizarUsuario($conexion, $id): void {
        // Actualización específica para Auto
        $sqlVehiculo = "UPDATE vehiculos SET marca = ?, modelo = ? WHERE id = ?";
        $stmtVehiculo = $conexion->prepare($sqlVehiculo);
        $stmtVehiculo->execute([$this->marca, $this->modelo, $id]);

        $sqlAuto = "UPDATE auto SET distancia = ?, costoPorKm = ? WHERE id = ?";
        $stmtAuto = $conexion->prepare($sqlAuto);
        $stmtAuto->execute([$this->distancia, $this->costoPorKm, $id]);
    }

    public function borrarVehiculo($conexion, $id) {
        try {
            // Iniciar transacción
            $conexion->beginTransaction();

            // Eliminar de la tabla específica
            $sqlEspecifico = "DELETE FROM auto WHERE id = ?";
            $stmtEspecifico = $conexion->prepare($sqlEspecifico);
            $stmtEspecifico->execute([$id]);

            // Eliminar de la tabla general
            $sqlGeneral = "DELETE FROM vehiculos WHERE id = ?";
            $stmtGeneral = $conexion->prepare($sqlGeneral);
            $stmtGeneral->execute([$id]);

            // Confirmar transacción
            $conexion->commit();
            echo "¡Vehículo borrado exitosamente!";
        } catch (Exception $e) {
            // Revertir transacción si algo falla
            $conexion->rollBack();
            echo "Error al borrar el vehículo: " . $e->getMessage();
        }
    }

}

class Camion extends Vehiculo {
    public function conectar($conexion): void {
        $sql = "INSERT INTO vehiculos (marca, modelo, tipo) VALUES (?, ?, 'camion')";
        $conexion = 'conexion'::conectar();
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $this->marca, PDO::PARAM_STR); // Cambia bind_param por bindValue
        $stmt->bindValue(2, $this->modelo, PDO::PARAM_STR);
        $stmt->execute();
        $id = $conexion->lastInsertId();


        $sqlCamion = "INSERT INTO camion (id, distancia, costoPorKm) VALUES (?, ?, ?)";
        $stmtCamion = $conexion->prepare($sqlCamion);
        $stmtCamion->bindValue(1, $id, PDO::PARAM_INT); 
        $stmtCamion->bindValue(2, $this->distancia, PDO::PARAM_STR); // Cambia bind_param por bindValue
        $stmtCamion->bindValue(3, $this->costoPorKm, PDO::PARAM_STR);
        $stmtCamion->execute();
    }
    public function ActualizarVehiculo($conexion, $id): void {
        // Actualización específica para Camion
        $sqlVehiculo = "UPDATE vehiculos SET marca = ?, modelo = ? WHERE id = ?";
        $stmtVehiculo = $conexion->prepare($sqlVehiculo);
        $stmtVehiculo->execute([$this->marca, $this->modelo, $id]);

        $sqlCamion = "UPDATE camion SET distancia = ?, costoPorKm = ? WHERE id = ?";
        $stmtCamion = $conexion->prepare($sqlCamion);
        $stmtCamion->execute([$this->distancia, $this->costoPorKm, $id]);
    }

    public function borrarVehiculo($conexion, $id): void {
        try {
            // Iniciar transacción
            $conexion->beginTransaction();

            // Eliminar de la tabla específica
            $sqlEspecifico = "DELETE FROM camion WHERE id = ?";
            $stmtEspecifico = $conexion->prepare($sqlEspecifico);
            $stmtEspecifico->execute([$id]);

            // Eliminar de la tabla general
            $sqlGeneral = "DELETE FROM vehiculos WHERE id = ?";
            $stmtGeneral = $conexion->prepare($sqlGeneral);
            $stmtGeneral->execute([$id]);

            // Confirmar transacción
            $conexion->commit();
            echo "¡Vehículo borrado exitosamente!";
        } catch (Exception $e) {
            // Revertir transacción si algo falla
            $conexion->rollBack();
            echo "Error al borrar el vehículo: " . $e->getMessage();
        }
    }

}

// Función Factory
function crearVehiculo($tipo, $marca, $modelo, $distancia, $costoPorKm) {
    switch ($tipo) {
        case 'moto':
            return new Moto($marca, $modelo, $distancia, $costoPorKm);
        case 'auto':
            return new Auto($marca, $modelo, $distancia, $costoPorKm);
        case 'camion':
            return new Camion($marca, $modelo, $distancia, $costoPorKm);
        default:
            throw new Exception("Tipo de vehículo no válido.");
    }
}

?>