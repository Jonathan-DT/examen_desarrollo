<?php
require_once("models/User.php");
require_once("library/loadview.php");
class LoginController
{
   private $carga;


    public function index()
    {
        // Preparar datos para la vista
        $testModel = new User(); // Suponiendo que tienes un modelo Test
        //$data = $testModel->get_data();
        $this->carga = new LoadView();
        // Incluir la vista y pasar los datos
        $this->carga->loadView('login', []);
    }

    public function access()
    {
        // Verificar si los datos se han enviado por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener datos del formulario
            $name = isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : '';
            $pass = isset($_POST['pass']) ? htmlspecialchars($_POST['pass']) : '';
            $redirectUrl = isset($_POST['redirect_url']) ? htmlspecialchars($_POST['redirect_url']) : '/home';
            // Configurar mensaje de éxito en la sesión
            session_start(); // Asegúrate de iniciar la sesión
            if (empty($name) || empty($pass)) {
                $_SESSION['message'] = "se deben llenar todos los campos";
                $_SESSION['message_type'] = "error"; // Puedes usar esto para diferenciar entre tipos de mensajes
                header("Location: $redirectUrl"); // Redirigir a la página anterior o a una página predeterminada
                exit; // Asegúrate de llamar a exit después de redirigir
            }
            
            // Aquí puedes hacer lo que necesites con los datos, como guardarlos en la base de datos
            // Por ejemplo, podrías usar un modelo para guardar los datos:
            $pacienteModel = new User();
            $success = $pacienteModel->get_data(strtolower($name), strtolower($pass));

            if ($success) {
                $_SESSION['message'] = "Logeado";
                $_SESSION['log'] = "Logeado";
                $_SESSION['message_type'] = "success"; // Puedes usar esto para diferenciar entre tipos de mensajes
                header("Location: $redirectUrl"); // Redirigir a la página anterior o a una página predeterminada
            } else {
                $_SESSION['message'] = "Hubo un problema al Loggear.";
                $_SESSION['message_type'] = "error"; // Puedes usar esto para diferenciar entre tipos de mensajes
            }
            exit; // Asegúrate de llamar a exit después de redirigir
        } else {
            // Manejo de errores si no es una solicitud POST
            echo "Solicitud no válida.";
        }
    }

}
