<?php
require '../src/autoload.php';
require '../config/Config.php';

use Daos\ResponseDao;
use Models\Response;

$responseDao = new ResponseDao(new Database(Config::getDbConfig()));

$response = $responseDao->getById(2);

$responseDao->delete($response);

/*
// $response->setText('Here is ANOTHER test');

// $responseDao->update($response);

echo '<pre>';

print_r($responses);

echo '</pre>';
*/


