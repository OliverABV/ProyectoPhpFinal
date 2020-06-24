<?php

/* function ConectarBD(){
  $host="host=localhost";
  $port="port=5432";
  $dbname="dbname=PruebaBD";
  $user="user=postgres";
  $password="password=1234";

  /*$StringConexionBD = pg_connect("$host $port $dbname $user $password");
  if(!$StringConexionBD){
  echo "Error ".pg_last_error();
  }else{
  echo "<h3>Conexion Exitosa</h3>";
  return $StringConexionBD;
  } */
define('NOMBRE_SERVIDOR', 'localhost');
define('NOMBRE_USUARIO', 'postgres');
define('PASSWORD', '1234');
define('BASE_DATOS', 'PruebaBD');

class ConexionBD {

    //put your code here
    private static $conexion;

    public static function abrirConexion() {
        if (!isset(self::$conexion)) {
            try {
                self::$conexion = new PDO('pgsql:host=' . NOMBRE_SERVIDOR . '; dbname=' . BASE_DATOS, NOMBRE_USUARIO, PASSWORD);
                self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$conexion->exec("SET NAMES 'UTF8'");
                return self::$conexion;
            } catch (Exception $ex) {
                print "ERROR" . $ex->getMessage() . "<br>";
            }
        }
    }

    public static function cerrarConexion() {
        if (isset(self::$conexion)) {
            self::$conexion = null;
          //  echo "Conexion cerrada";
        }
    }

    public static function probarConexion() {
        if (isset(self::$conexion)) {
            echo "Conexion establecida";
        } else {
            echo "Error conexion bd";
        }
    }

}

?>