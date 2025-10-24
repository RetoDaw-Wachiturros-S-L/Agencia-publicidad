<?php

class Router {
    
    // Como el router no tiene estados, los métodos pueden ser estáticos.
    public static function dispatch() {
        // Determinar controlador (por defecto EmpleadoController)
        $controllerName = $_GET['controller'] ?? 'MainController';
        
        // Determinar acción (por defecto index)
        $action = $_GET['accion'] ?? 'index';
        
        // Cargar y ejecutar controlador
        try {
            self::loadController($controllerName, $action);
        } catch (Exception $e) {
            // Si hay un error, mostrar la página 404 personalizada
            self::show404();
        }
    }
    
    private static function loadController($controllerName, $action){
        define('ACCESSED_VIA_ROUTER', true); // Evita acceder directamente por url
        // Construir ruta del archivo del controlador
        $controllerFile = "./controllers/{$controllerName}.php";

        // Verificar si el archivo del controlador existe
        if (!file_exists($controllerFile)) {
            self::show404();
            return;
        }

        require_once $controllerFile;
        
        // Instanciar controlador (soporta clases con o sin namespace)
        $fqcnNamespaced = "AgenciaPublicidad\\Controllers\\{$controllerName}";
        if (class_exists($fqcnNamespaced)) {
            $controller = new $fqcnNamespaced();
        } elseif (class_exists($controllerName)) {
            $controller = new $controllerName();
        } else {
            self::show404();
            return;
        }

        // Verificar si el método existe
        if (!method_exists($controller, $action)) {
            self::show404();
            return;
        }

        // Ejecutar método
        $controller->$action();
    }
    
    private static function show404() {
        http_response_code(404);
        define('BASE_URL', '/Agencia-publicidad/Agencia-publicidad');
        require_once __DIR__ . '/views/errors/404.php';
        exit;
    }

}