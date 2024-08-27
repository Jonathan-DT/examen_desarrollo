<?php
require_once("db/conn.php");
// Obtener la ruta solicitada
$requestUri = $_SERVER['REQUEST_URI'];
$requestUri = parse_url($requestUri, PHP_URL_PATH);
$requestUri = trim($requestUri, '/'); // Elimina las barras al principio y al final

// Dividir la ruta en partes
$parts = explode('/', $requestUri);

// Determinar el controlador y la acción
$controllerName = isset($parts[0]) && !empty($parts[0]) ? $parts[0] : 'login';
$action = isset($parts[1]) ? $parts[1] : 'index';
$params = array_slice($parts, 2); // Captura parámetros adicionales

// Controlador por defecto
$controllerFile = "controllers/{$controllerName}_controller.php";

if (file_exists($controllerFile)) {
    require_once($controllerFile);

    // Crear instancia del controlador
    $controllerClass = ucfirst($controllerName) . 'Controller';
    if (class_exists($controllerClass)) {
        $controller = new $controllerClass();
        $viewName = new LoadView();

        // // Pasar la variable al controlador si es necesario
        if (method_exists($viewName, 'setControllerFile')) {
            $viewName->setControllerFile($controllerName);
        }

        // Verificar si la acción existe en el controlador
        if (method_exists($controller, $action)) {
            call_user_func_array([$controller, $action], $params);
        } else {
            echo "Acción '{$action}' no encontrada en el controlador '{$controllerClass}'.";
        }
    } else {
        echo "Controlador '{$controllerClass}' no encontrado.";
        //include $viewFile; //vista del NotFound (404)
    }
} else {
    echo "Archivo de controlador '{$controllerFile}' no encontrado.";
}
?>