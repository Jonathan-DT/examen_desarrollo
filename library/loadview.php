<?php
class LoadView
{
    
    private $controllerName;

    public function setControllerFile($file)
    {
        $this->controllerName = $file;
    }

    public function loadView($viewPath, $data = [])
    {
        // Extraer datos para que estén disponibles como variables en la vista
        extract($data);

        // Incluir la vista
        //var_dump($this->controllerName); 
        $viewFile = "views/{$viewPath}/{$viewPath}_view.phtml";
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo "Vista '{$viewFile}' no encontrada.";
        }
    }
}
