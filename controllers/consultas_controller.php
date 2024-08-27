<?php
require_once("models/Pacientes.php");
require_once("models/Medicos.php");
require_once("models/Diagnosticos.php");
require_once("models/Consultas.php");
require_once("library/loadview.php");
class ConsultasController
{
    private $carga;
    //private $data
    public function index()
    {
        // Crear instancias de los modelos
        $testModel = new Medicos();
        $pacienteModel = new Pacientes();
        $diagModel = new Diagnosticos();

        // Obtener datos de los modelos
        $medicosData = $testModel->get_data(); // Datos de médicos
        $pacientesData = $pacienteModel->get_data(); // Datos de pacientes
        $diagData = $diagModel->get_data(); // Datos de cat diagnosticos

        // Preparar datos para la vista
        $data = [
            'medicos' => $medicosData,
            'pacientes' => $pacientesData,
            'diagnosticos' => $diagData
        ];
        // Cargar la vista y pasar los datos
        $this->carga = new LoadView();
        $this->carga->loadView('consultas', $data);
    }

    function convertirFechaParaMostrar($fecha) {
        // Convertir la fecha de yyyy-mm-dd a dd/mm/aaaa
        $fechaConvertida = DateTime::createFromFormat('Y-m-d', $fecha);
        if ($fechaConvertida === false) {
            return false; // Fecha inválida
        }
        return $fechaConvertida->format('d/m/Y'); // dd/mm/aaaa
    }

    public function store()
    {
        // Verificar si los datos se han enviado por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del formulario
            $fecha = isset($_POST['fecha']) ? htmlspecialchars($_POST['fecha']) : '';
            $medico = isset($_POST['medico']) ? htmlspecialchars($_POST['medico']) : '';
            $paciente = isset($_POST['paciente']) ? htmlspecialchars($_POST['paciente']) : '';
            $diagnostico = isset($_POST['diagnostico']) ? htmlspecialchars($_POST['diagnostico']) : '';
            $tratamiento = isset($_POST['tratamiento']) ? htmlspecialchars($_POST['tratamiento']) : '';
            $costo = isset($_POST['costo']) ? htmlspecialchars($_POST['costo']) : '';
            $redirectUrl = isset($_POST['redirect_url']) ? htmlspecialchars($_POST['redirect_url']) : '/consultas';
            // Configurar mensaje de éxito en la sesión
            session_start(); // Asegúrate de iniciar la sesión
            if (empty($fecha) || empty($costo) || empty($tratamiento)) {
                $_SESSION['message'] = "se deben llenar todos los campos";
                $_SESSION['message_type'] = "error"; // Puedes usar esto para diferenciar entre tipos de mensajes
                header("Location: $redirectUrl"); // Redirigir a la página anterior o a una página predeterminada
                exit; // Asegúrate de llamar a exit después de redirigir
            }

            // Aquí puedes hacer lo que necesites con los datos, como guardarlos en la base de datos
            // Por ejemplo, podrías usar un modelo para guardar los datos:
            $testModel = new Consultas();
            $success = $testModel->saveData($fecha, $medico, $paciente, $diagnostico, $tratamiento, $costo);


            if ($success) {
                $_SESSION['message'] = "Dato creado con éxito";
                $_SESSION['message_type'] = "success"; // Puedes usar esto para diferenciar entre tipos de mensajes
                header("Location: $redirectUrl"); // Redirigir a la página anterior o a una página predeterminada
            } else {
                $_SESSION['message'] = "Hubo un problema al guardar los datos.";
                $_SESSION['message_type'] = "error"; // Puedes usar esto para diferenciar entre tipos de mensajes
            }
            exit; // Asegúrate de llamar a exit después de redirigir
        } else {
            // Manejo de errores si no es una solicitud POST
            echo "Solicitud no válida.";
        }
    }
}
