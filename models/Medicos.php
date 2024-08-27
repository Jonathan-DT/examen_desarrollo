<?php

class Medicos
{
    private $medico;
    private $db;

    function __construct()
    {
        $this->db = Conectar::conexion();
        $this->medico = array();
    }

    public function get_data()
    {
        $sql = "SELECT * FROM medicos";
        if ($consulta = $this->db->query($sql)) {
            // Asegúrate de que test sea un array de arrays
            $this->medico = array(); // Inicializa el array vacío

            while ($filas = $consulta->fetch_assoc()) {
                $this->medico[] = $filas; // Agrega cada fila al array $medico
            }

            $consulta->free(); // liberamos memoria del resultado

            return $this->medico;
        }else{
            echo "Error al ejecutar la consulta: " . $this->db->error;
        }
        return false; // Retorna falso si hubo un error
    }

    // Método para obtener un registro por ID
    public function getDataById($id)
    {
        // Preparar la consulta SQL
        $sql = "SELECT * FROM tb_test WHERE id = ?";

        // Preparar la sentencia
        if ($stmt = $this->db->prepare($sql)) {
            // Enlazar el parámetro
            $stmt->bind_param('i', $id);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Obtener el resultado
                $result = $stmt->get_result();
                $data = $result->fetch_assoc();
                $stmt->close();
                return $data; // Retorna el registro encontrado
            } else {
                echo "Error al ejecutar la consulta: " . $this->db->error;
            }
        } else {
            echo "Error al preparar la consulta: " . $this->db->error;
        }

        return false; // Retorna falso si hubo un error o si no se encontró el registro
    }

    // Método para actualizar un registro en la base de datos
    public function updateData($id, $name, $email)
    {
        // Preparar la consulta SQL
        $sql = "UPDATE tb_test SET name = ?, descrip = ? WHERE id = ?";

        // Preparar la sentencia
        if ($stmt = $this->db->prepare($sql)) {
            // Enlazar los parámetros
            $stmt->bind_param('ssi', $name, $email, $id); // ´i´ es integer ´s´ string ´d´ double ´b´ blob

            // Ejecutar la consulta
            if ($stmt->execute()) {
                $stmt->close();
                return true; // Retorna verdadero si la actualización fue exitosa
            } else {
                echo "Error al ejecutar la consulta: " . $this->db->error;
            }
        } else {
            echo "Error al preparar la consulta: " . $this->db->error;
        }

        return false; // Retorna falso si hubo un error
    }

    // Método para eliminar un registro de la base de datos
    public function deleteData($id)
    {
        // Preparar la consulta SQL
        $sql = "DELETE FROM tb_test WHERE id = ?";

        // Preparar la sentencia
        if ($stmt = $this->db->prepare($sql)) {
            // Enlazar el parámetro
            $stmt->bind_param('i', $id);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                $stmt->close();
                return true; // Retorna verdadero si la eliminación fue exitosa
            } else {
                echo "Error al ejecutar la consulta: " . $this->db->error;
            }
        } else {
            echo "Error al preparar la consulta: " . $this->db->error;
        }

        return false; // Retorna falso si hubo un error
    }


    // Método para guardar datos en la base de datos
    public function saveData($name, $curp)
    {
        // Preparar la consulta SQL
        $sql = "INSERT INTO medicos (nombre,cedula) VALUES (?, ?)";

        // Preparar la sentencia
        if ($stmt = $this->db->prepare($sql)) {
            // Enlazar los parámetros
            $stmt->bind_param('si', $name, $curp);

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
