<?php
namespace Controllers;

use Models\Scenario;
use Models\Department;
use Models\Response;
use Daos\ScenarioDao;
use Daos\DepartmentDao;
use Daos\ResponseDao;
use Views\DepartmentsView;
use Views\ScenariosView;
use Views\ScenarioView;
use Config;
use Database;

class ScenariosController extends BaseController {
    private ScenarioDao $scenarioDao;
    private DepartmentDao $departmentDao;

    public function __construct($router, $requestMethod) {
        parent::__construct($router, $requestMethod);

        $db = new Database(Config::getDbConfig());

        $this->scenarioDao = new ScenarioDao($db);
        $this->departmentDao = new DepartmentDao($db);
        $this->responseDao = new ResponseDao($db);
    }

    public function beforeAction() {
        if(isset($_SESSION['leaderengine']['user_id'])) {
            return true;
        }

        $this->getRouter()->route(['controller' => 'login']);

        return false;
    }

    public function index($departmentId = null, $scenarioId = null) {
        if($scenarioId) {
            $scenario = $this->scenarioDao->getById($scenarioId);

            $responses = $this->responseDao->getByScenarioId($scenarioId);

            $view = new ScenarioView($scenario, $responses);

            $view->render();
        } else if($departmentId) {
            $department = $this->departmentDao->getById($departmentId);

            $scenarios = $this->scenarioDao->getByDepartmentId($departmentId);

            $view = new ScenariosView($department->getName(), $scenarios);

            $view->render();
        } else {
            $departments = $this->departmentDao->getAll();

            $view = new DepartmentsView($departments);

            $view->render();
        }
    }
}