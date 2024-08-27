<?php
class Consultas{
    private $consulta;
    private $db;

    function __construct()
    {
        $this->db = Conectar::conexion();
        $this->consulta = array();
    }

    public function get_data()
    {
        $sql = "SELECT * FROM consultas";
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


        // Método para guardar datos en la base de datos
        public function saveData($fecha, $medico,$paciente,$diagnostico,$tratamiento,$costo)
        {
            // Preparar la consulta SQL
            $sql = "INSERT INTO consulta (medico_id,paciente_id,diagnostico_id,tratamiento,costo,fecha_consulta) VALUES (?, ? ,? ,? ,? ,?)";
    
            // Preparar la sentencia
            if ($stmt = $this->db->prepare($sql)) {
                // Enlazar los parámetros
                $stmt->bind_param('iiisds', $medico, $paciente,$diagnostico,$tratamiento,$costo,$fecha);
    
                // Ejecutar la consulta
                if ($stmt->execute()) {
                    $stmt->close();
                    return true; // Retorna verdadero si la inserción fue exitosa
                } else {
                    echo "Error al ejecutar la consulta: " . $this->db->error;
                }
            } else {
                echo "Error al preparar la consulta: " . $this->db->error;
            }
    
            return false; // Retorna falso si hubo un error
        }

}