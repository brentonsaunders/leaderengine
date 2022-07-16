<?php
require '../src/init.php';

$router = new Router();

$router->route($_REQUEST, $_SERVER['REQUEST_METHOD']);