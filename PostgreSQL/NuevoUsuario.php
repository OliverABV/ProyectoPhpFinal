<?php

include_once 'ConexionBD.php';

class NuevoRegistro {

    public function __construct() {
        
    }

    public function registarEntidad($Entidad) {

        $rut = $Entidad->getRut();
        $email = $Entidad->getEmail();
        $password = $Entidad->getPassword();
        $razonSocial = $Entidad->getRazonSocial();
        $nombreComercial = $Entidad->getNombreComercial();
        $rol = $Entidad->getRol();
        $pais = $Entidad->getPais();
        $region = $Entidad->getRegion();
        $ciudad = $Entidad->getCiudad();
        $comuna = $Entidad->getComuna();
        $calle = $Entidad->getCalle();
        $numero = $Entidad->getNumero();
        $piso = $Entidad->getPiso();
        $telefono = $Entidad->getTelefono();
        $ruta = $Entidad->getRuta();
        $archivo = $Entidad->getArchivo();

        //verificar que ya no exista el RUT en la BD
        $consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT COUNT(rut_entidad) FROM entidad WHERE rut_entidad = ?");
        $consultaSQL->bindParam(1, $rut);
        $consultaSQL->execute();

        if ($consultaSQL->fetchColumn() == 0) {
            ConexionBD::cerrarConexion();

            //crear la query para almacenar los datos
            $consultaSQL = ConexionBD::abrirConexion()->prepare("INSERT INTO entidad (rut_entidad, email_entidad, password_entidad, razon_social_entidad, nombre_comercial_entidad, rol_entidad, pais_entidad, id_region, id_ciudad, id_comuna, calle_entidad, numero_entidad, piso_entidad, telefono_entidad, foto_entidad) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $consultaSQL->bindParam(1, $rut);
            $consultaSQL->bindParam(2, $email);
            $consultaSQL->bindParam(3, $password);
            $consultaSQL->bindParam(4, $razonSocial);
            $consultaSQL->bindParam(5, $nombreComercial);
            $consultaSQL->bindParam(6, $rol);
            $consultaSQL->bindParam(7, $pais);
            $consultaSQL->bindParam(8, $region);
            $consultaSQL->bindParam(9, $ciudad);
            $consultaSQL->bindParam(10, $comuna);
            $consultaSQL->bindParam(11, $calle);
            $consultaSQL->bindParam(12, $numero);
            $consultaSQL->bindParam(13, $piso);
            $consultaSQL->bindParam(14, $telefono);
            $consultaSQL->bindParam(15, $ruta);

            if ($consultaSQL->execute()) {
                move_uploaded_file($archivo, $ruta);
                echo "<script>alert('USUARIO REGISTRADO');</script>";
            } else {

                echo "<script>alert('ERROR EN REGISTRO');</script>";
                // echo 'Error occurred:'.implode(":",$this->$consultaSQL->errorInfo());
            }
        } else {
            // si el rut ya existe ejecutar esto
            // header('Location: ./index.php');
            ConexionBD::cerrarConexion();
            echo "<script>alert('EL RUT INGRESADO YA EXISTE');</script>";
        }
    }

    public function registarUsuario($Usuario) {

        $rut = $Usuario->getRut();
        $password = $Usuario->getPassword();
        $nombre = $Usuario->getNombre();
        $apellidopat = $Usuario->getApellidoPat();
        $apellidomat = $Usuario->getApellidoMat();
        $sexo = $Usuario->getSexo();
        $pais = $Usuario->getPais();
        $region = $Usuario->getRegion();
        $ciudad = $Usuario->getCiudad();
        $comuna = $Usuario->getComuna();
        $fecha_nac = $Usuario->getFechaNacimiento();
        $email = $Usuario->getEmail();
        $telefono = $Usuario->getTelefono();
        $ruta = $Usuario->getRuta();
        $archivo = $Usuario->getArchivo();

        //verificar que ya no exista el RUT en la BD
        $consultaSQL = ConexionBD::abrirConexion()->prepare("SELECT COUNT(rut_usuario) FROM usuario2 WHERE rut_usuario = ?");
        $consultaSQL->bindParam(1, $rut);
        $consultaSQL->execute();

        if ($consultaSQL->fetchColumn() == 0) {
            ConexionBD::cerrarConexion();

            $consultaSQL = ConexionBD::abrirConexion()->prepare("INSERT INTO usuario2 (rut_usuario, password_usuario, nombre_usuario, apellidopat_usuario, apellidomat_usuario, sexo_usuario, pais_usuario, id_region, id_ciudad, id_comuna, fechanac_usuario, email_usuario, telefono_usuario, certificado_usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $consultaSQL->bindParam(1, $rut);
            $consultaSQL->bindParam(2, $password);
            $consultaSQL->bindParam(3, $nombre);
            $consultaSQL->bindParam(4, $apellidopat);
            $consultaSQL->bindParam(5, $apellidomat);
            $consultaSQL->bindParam(6, $sexo);
            $consultaSQL->bindParam(7, $pais);
            $consultaSQL->bindParam(8, $region);
            $consultaSQL->bindParam(9, $ciudad);
            $consultaSQL->bindParam(10, $comuna);
            $consultaSQL->bindParam(11, $fecha_nac);
            $consultaSQL->bindParam(12, $email);
            $consultaSQL->bindParam(13, $telefono);
            $consultaSQL->bindParam(14, $ruta);

            if ($consultaSQL->execute()) {
                move_uploaded_file($archivo, $ruta);
                echo "<script>alert('USUARIO REGISTRADO');</script>";
            } else {

                echo "<script>alert('ERROR EN REGISTRO');</script>";
                // echo 'Error occurred:'.implode(":",$this->$consultaSQL->errorInfo());
            }
        } else {
            // si el rut ya existe ejecutar esto
            // header('Location: ./index.php');
            ConexionBD::cerrarConexion();
            echo "<script>alert('EL RUT INGRESADO YA EXISTE');</script>";
        }
    }

}

?>