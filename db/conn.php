<?php
class Conectar{
    public static function conexion(){
        $conexion=new mysqli("localhost", "jona", "Jona123.", "examen_desarrollo");
        $conexion->query("SET NAMES 'utf8'");
        return $conexion;
    }
}
?>
