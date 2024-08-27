<?php
class User{
    private $consulta;
    private $db;

    function __construct()
    {
        $this->db = Conectar::conexion();
        $this->consulta = array();
    }

    public function get_data($user,$password)
    {
        $sql = "SELECT * FROM tb_user where user = '".$user."' and contra ='".$password."'";
        if ($consulta = $this->db->query($sql)) {
            // Asegúrate de que test sea un array de arrays
            $this->consulta = array(); // Inicializa el array vacío

            while ($filas = $consulta->fetch_assoc()) {
                $this->consulta[] = $filas; // Agrega cada fila al array $consulta
            }

            return isset($this->consulta)?true:false;
        }else{
            //echo "Error al ejecutar la consulta: " . $this->db->error;
            return false;
        }
        return false; // Retorna falso si hubo un error
    }
}