<?php
class Diagnosticos{
    private $consulta;
    private $db;

    function __construct()
    {
        $this->db = Conectar::conexion();
        $this->consulta = array();
    }

    public function get_data()
    {
        $sql = "SELECT * FROM diagnosticos";
        if ($consulta = $this->db->query($sql)) {
            // Asegúrate de que test sea un array de arrays
            $this->consulta = array(); // Inicializa el array vacío

            while ($filas = $consulta->fetch_assoc()) {
                $this->consulta[] = $filas; // Agrega cada fila al array $consulta
            }

            $consulta->free(); // liberamos memoria del resultado

            return $this->consulta;
        }else{
            echo "Error al ejecutar la consulta: " . $this->db->error;
        }
        return false; // Retorna falso si hubo un error
    }

}