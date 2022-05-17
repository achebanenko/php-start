<?php

class Router
{
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include($routesPath);
    }

    private function getUri()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim(str_replace('php-start', '', $_SERVER['REQUEST_URI']), '/');
        }
    }
    
    public function run()
    {
        $uri = $this->getUri();

        foreach ($this->routes as $uriPattern => $path) {
            // if (preg_match("/$uriPattern/", $uri)) {
            if (preg_match("~$uriPattern~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                $segments = explode('/', $internalRoute);

                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action'.ucfirst(array_shift($segments));
                $parameters = $segments;


                $controllerFile = ROOT.'/controllers/'.$controllerName.'.php';

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                $controllerObject = new $controllerName;

                // $result = $controllerObject->$actionName($parameters);
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                if ($result != null) {
                    break;
                }
            }
        }
    }
}
