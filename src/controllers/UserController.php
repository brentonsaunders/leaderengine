<?php
namespace Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/PHPMailer-master/src/Exception.php';
require '../vendor/PHPMailer-master/src/PHPMailer.php';
require '../vendor/PHPMailer-master/src/SMTP.php';

use Models\User;
use Daos\UserDao;
use Config;
use Database;

class UserController extends BaseController {
    private $userDao = null;

    public function __construct($router, $requestMethod) {
        parent::__construct($router, $requestMethod);

        $this->userDao = new UserDao(new Database(Config::getDbConfig()));
    }

    public function index($id = null, $email = null) {
        if($id !== null) {
            $user = $this->userDao->getById($id);
        } else if($email !== null) {
            $user = $this->userDao->getByEmail($email);
        }

        if(!$user) {
            http_response_code(404);

            return false;
        }

        header('Content-type: application/json');

        echo json_encode([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'name' => $user->getName(),
            'verified' => $user->getVerified(),
            'codeExpired' => false
        ]);

        return true;
    }
}