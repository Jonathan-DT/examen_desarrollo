<?php
require_once("models/Medicos.php");
require_once("library/loadview.php");
class MedicosController
{
    private $carga;

    public function index()
    {
        // Preparar datos para la vista
        $testModel = new Medicos(); // Suponiendo que tienes un modelo Test
        $data = $testModel->get_data();
        $this->carga = new LoadView();
        // Incluir la vista y pasar los datos
        $this->carga->loadView('medicos', $data);
    }

    public function store()
    {
        // Verificar si los datos se han enviado por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del formulario
            $name = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
            $curp = isset($_POST['cedula']) ? htmlspecialchars($_POST['cedula']) : '';
            $redirectUrl = isset($_POST['redirect_url']) ? htmlspecialchars($_POST['redirect_url']) : '/pacientes/index';
            // Configurar mensaje de éxito en la sesión
            session_start(); // Asegúrate de iniciar la sesión
            if (empty($name) || empty($curp)) {
                $_SESSION['message'] = "se deben llenar todos los campos";
                $_SESSION['message_type'] = "error"; // Puedes usar esto para diferenciar entre tipos de mensajes
                header("Location: $redirectUrl"); // Redirigir a la página anterior o a una página predeterminada
                exit; // Asegúrate de llamar a exit después de redirigir
            }
            // Aquí puedes hacer lo que necesites con los datos, como guardarlos en la base de datos
            // Por ejemplo, podrías usar un modelo para guardar los datos:
            $pacienteModel = new Medicos();
            $success = $pacienteModel->saveData(strtoupper($name), strtoupper($curp));

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
