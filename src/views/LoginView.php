<?php
namespace Views;

class LoginView extends TemplateView {
    public function __construct() {
        parent::__construct('login.php');

        $this->addScript('js/login.js');
        $this->addStylesheet('css/login.css');
    }
}