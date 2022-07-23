<?php
namespace Controllers;

use Models\Scenario;
use Models\Department;
use Models\Response;
use Models\User;
use Models\ResponseUserLikes;
use Daos\ScenarioDao;
use Daos\DepartmentDao;
use Daos\ResponseDao;
use Daos\ResponseLikesDao;
Use Daos\UserDao;
use Views\DepartmentsView;
use Views\ScenariosView;
use Views\ScenarioView;
use Config;
use Database;

class ScenariosController extends BaseController {
    private ScenarioDao $scenarioDao;
    private DepartmentDao $departmentDao;
    private UserDao $userDao;
    private ResponseLikesDao $responseLikesDao;

    public function __construct($router, $requestMethod) {
        parent::__construct($router, $requestMethod);

        $db = new Database(Config::getDbConfig());

        $this->scenarioDao = new ScenarioDao($db);
        $this->departmentDao = new DepartmentDao($db);
        $this->responseDao = new ResponseDao($db);
        $this->userDao = new UserDao($db);
        $this->responseLikesDao = new ResponseLikesDao($db);
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

            $responseUserLikes = [];

            foreach($responses as $response) {
                $user = $this->userDao->getById($response->getUserId());

                $likes = $this->responseLikesDao->getByResponseId($response->getId());

                $likedByCurrentUser = ($this->responseLikesDao->getByResponseIdAndUserId($response->getId(),
                    $_SESSION['leaderengine']['user_id']) === 1) ? true : false;

                $responseUserLikes[] = new ResponseUserLikes($response, $user, $likes,
                    $likedByCurrentUser);
            }

            $view = new ScenarioView($scenario, $responseUserLikes);

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