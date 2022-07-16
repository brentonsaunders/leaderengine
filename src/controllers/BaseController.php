<?php
namespace Controllers;

abstract class BaseController {
    private $router = null;
    private $requestMethod = null;
    private $postData = [];

    public function __construct($router, $requestMethod) {
        $this->router = $router;
        $this->requestMethod = strtoupper($requestMethod);
    }

    protected function getRouter() {
        return $this->router;
    }

    protected function getRequestMethod() {
        return $this->requestMethod;
    }

    protected function getPostData() {
        return $this->postData;
    }

    public function setPostData($postData) {
        $this->postData = filter_var_array($postData, FILTER_SANITIZE_STRING);
    }

    public function beforeAction() {
        return true;
    }
}