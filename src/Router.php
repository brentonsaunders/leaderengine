<?php
use Controllers\DefaultController;

class Router {
    public function __constructor() {

    }

    public function route($request, $requestMethod = 'GET') {
        $controllerName = null;
        $actionName = null;

        if(isset($request['controller'])) {
            $controllerName = 'Controllers\\' . $request['controller'] . 'Controller';
        } else {
            $controllerName = 'Controllers\\DefaultController';
        }

        if(isset($request['action'])) {
            $actionName = $request['action'];
        } else {
            $actionName = 'index';
        }

        unset($request['controller']);
        unset($request['action']);

        if(!class_exists($controllerName)) {
            return false;
        }

        $controller = new $controllerName($this, $requestMethod);

        if(!$controller->beforeAction()) {
            return false;
        }

        if(!method_exists($controller, $actionName)) {
            return false;
        }

        if(strtoupper($requestMethod) === 'POST') {
            $controller->setPostData($request);

            $request = [];
        }

        call_user_func_array([$controller, $actionName], $request);

        return true;
    }
}