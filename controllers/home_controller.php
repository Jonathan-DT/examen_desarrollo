<?php
require_once("models/Datos_consultas.php");
require_once("library/loadview.php");
class HomeController
{
   private $carga;


    public function index()
    {
        // Preparar datos para la vista
        $testModel = new DatosConsultas(); // Suponiendo que tienes un modelo Test
        $data = $testModel->get_data();
        $this->carga = new LoadView();
        // Incluir la vista y pasar los datos
        $this->carga->loadView('home', $data);
    }

    public function view($id)
    {
        // Código para manejar una acción con parámetros
        echo "Ver Persona con ID: $id";
    }


}
