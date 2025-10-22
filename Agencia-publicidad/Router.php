<?php

class Router {
    
    // Como el router no tiene estados, los métodos pueden ser estáticos.
    public static function dispatch() {
        // Determinar controlador (por defecto EmpleadoController)
        $controllerName = $_GET['controller'] ?? 'MainController';
        
        // Determinar acción (por defecto index)
        $action = $_GET['accion'] ?? 'index';
        
        // Cargar y ejecutar controlador
        self::loadController($controllerName, $action);
    }
    
    private static function loadController($controllerName, $action){
        define('ACCESSED_VIA_ROUTER', true); // Evita acceder directamente por url
        // Construir ruta del archivo del controlador
        $controllerFile = "./controllers/{$controllerName}.php";

        /* DEBUG: Mostrar qué archivo está buscando
        echo "Buscando: " . $controllerFile . "<br>";
        echo "¿Existe? " . (file_exists($controllerFile) ? "SÍ" : "NO") . "<br>";
        */

        require_once $controllerFile;
        
        // Instanciar controlador (soporta clases con o sin namespace)
        $fqcnNamespaced = "AgenciaPublicidad\\Controllers\\{$controllerName}";
        if (class_exists($fqcnNamespaced)) {
            $controller = new $fqcnNamespaced();
        } elseif (class_exists($controllerName)) {
            $controller = new $controllerName();
        } else {
            throw new Exception("No se encontró la clase del controlador: {$controllerName}");
        }

        // Ejecutar método
        $controller->$action();
    }
    

}