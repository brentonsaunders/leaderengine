<?php
namespace Controllers;

use Controllers\BaseController;

use Views\View;
use Views\TemplateView;
use Views\DepartmentsView;
use Models\Department;
use Daos\DepartmentDao;
use Database;
use Config;

class DefaultController extends BaseController {
    public function __construct($router, $requestMethod) {
        parent::__construct($router, $requestMethod);
    }

    public function beforeAction() {
        if(isset($_SESSION['leaderengine']['user_id'])) {
            return true;
        }

        $this->getRouter()->route(['controller' => 'login']);

        return false;
    }

    public function index() {
        $view = new TemplateView('home.php');

        $view->setActiveNavItem('home');
        $view->setTitle('Home');

        $view->render();
    }

    public function scenarios() {
        
    }

    public function about() {
        $view = new TemplateView('about.php');

        $view->setActiveNavItem('about');
        $view->setTitle('About');

        $view->render();
    }

    public function privacy() {
        $view = new TemplateView('privacy.php');

        $view->setActiveNavItem('privacy');
        $view->setTitle('Privacy');

        $view->render();
    }
}