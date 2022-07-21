<?php
require '../src/autoload.php';
require '../config/Config.php';

use Daos\ScenarioDao;
use Models\Scenario;

$scenarioDao = new ScenarioDao(new Database(Config::getDbConfig()));

$scenario = $scenarioDao->getById(2);

$scenario->setTitle('New Title');
$scenario->setApproved(true);
$scenario->setEditorId(2);

$scenarioDao->delete($scenario);

echo '<pre>';

print_r($scenario);

echo '</pre>';



