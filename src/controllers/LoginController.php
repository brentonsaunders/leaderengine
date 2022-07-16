<?php
namespace Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/PHPMailer-master/src/Exception.php';
require '../vendor/PHPMailer-master/src/PHPMailer.php';
require '../vendor/PHPMailer-master/src/SMTP.php';

use Models\User;
use Daos\UserDao;
use Views\LoginView;
use Config;
use Database;

class LoginController extends BaseController {
    private $userDao = null;

    public function __construct($router, $requestMethod) {
        parent::__construct($router, $requestMethod);

        $this->userDao = new UserDao(new Database(Config::getDbConfig()));
    }

    private function generateVerificationCode() {
        $digits = '0123456789';

        $code = '';

        for($i = 0; $i < 5; ++$i) {
            $code .= $digits[rand(0, strlen($digits) - 1)];
        }

        return $code;
    }

    private function sendVerificationEmail($email, $name, $verificationCode) {
        $mail = new PHPMailer(true);
  
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host       = 'smtp.ipage.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'leaderengine@brentonsaunders.me';
            $mail->Password   = 'rE2r[bJb';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('leaderengine@brentonsaunders.me', 'Leader Engine Team');
            $mail->addAddress($email, $name);

            $mail->isHTML(true);                                  
            $mail->Subject = 'Leader Engine Verification Code';

            ob_start();

            require Config::getTemplateDir() . DIRECTORY_SEPARATOR . 'verify.php';

            $mail->Body = ob_get_clean();

            $mail->send();
        } catch (Exception $e) {
            echo 'Error sending email: ' . $mail->ErrorInfo;
        }
    }

    protected function sendVerificationCode(User $user) {
        $verificationCode = $this->generateVerificationCode();

        $user->setVerificationCode($verificationCode);
        $user->setVerificationExpiry(date('Y-m-d H:i:s', strtotime('+15 minutes')));
        
        $this->userDao->update($user);

        $this->sendVerificationEmail($user->getEmail(), $user->getName(), $verificationCode);
    }

    public function verify($email = '') {
        $method = $this->getRequestMethod();

        if($method === 'POST') {
            $postData = $this->getPostData();

            header('Content-type: application/json');

            if(isset($postData['email']) &&
               isset($postData['code'])) {
                $email = $postData['email'];
                $code = $postData['code'];

                $user = $this->userDao->getByEmail($email);

                if(!$user) {
                    echo json_encode([
                        'success' => false
                    ]);

                    return false;
                }

                if($user->verificationExpired()) {
                    echo json_encode([
                        'success' => false,
                        'hasExpired' => true
                    ]);

                    return false;
                }

                if($user->getVerificationCode() != $code) {
                    echo json_encode([
                        'success' => false
                    ]);

                    return false;
                }

                $user->setVerified(true);

                $this->userDao->update($user);

                $_SESSION['leaderengine']['email_verified'] = true;

                echo json_encode([
                    'success' => true
                ]);

                return true;
            }

            return false;
        } else if($method === 'GET') {
            header('Content-type: application/json');

            $user = $this->userDao->getByEmail($email);

            if(!$user) {
                echo json_encode([
                    'success' => false
                ]);

                return false;
            }

            $this->sendVerificationCode($user);

            $_SESSION['leaderengine']['email_verified'] = false;

            echo json_encode([
                'success' => true
            ]);

            return true;
        }
    }

    public function signup() {
        if($this->getRequestMethod() === 'POST') {
            $postData = $this->getPostData();

            header('Content-type: application/json');

            if(isset($postData['email']) &&
               isset($postData['name']) &&
               isset($postData['password'])) {
                $email = $postData['email'];
                $name = $postData['name'];
                $password = $postData['password'];

                $user = $this->userDao->getByEmail($email);

                if($user) {
                    echo json_encode([
                        'success' => false,
                        'emailExists' => true
                    ]);

                    return false;
                }

                $verificationCode = $this->generateVerificationCode();

                $user = new User(
                    null,
                    $email,
                    $password,
                    null,
                    $name,
                    false,
                    null,
                    null
                );

                $this->userDao->insert($user);

                echo json_encode([
                    'success' => true
                ]);

                return true;
            }

            return false;
        }
    }

    public function index() {
        if($this->getRequestMethod() === 'POST') {
            $postData = $this->getPostData();

            header('Content-type: application/json');

            if(isset($postData['email']) && isset($postData['password'])) {
                $email = $postData['email'];
                $password = $postData['password'];

                $user = $this->userDao->getByEmail($email);

                if($user) {
                    if(password_verify($password, $user->getHash())) {
                        if(!$user->getVerified()) {
                            echo json_encode(['success' => false, 'mustVerify' => true]);

                            if($user->verificationExpired()) {
                                $verificationCode = $this->generateVerificationCode();

                                $user->setVerificationCode($verificationCode);
                                $user->setVerificationExpiry(date('Y-m-d H:i:s', strtotime('+15 minutes')));
                    
                                $this->userDao->update($user);

                                $this->sendVerificationEmail($user->getEmail(), $user->getName(), $verificationCode);
                            }
    
                            return false;
                        }

                        $_SESSION['leaderengine'] = [
                            'user_id' => $user->getId()
                        ];

                        echo json_encode(['success' => true]);

                        return true;
                    }
                }
            }

            echo json_encode(['success' => false]);

            return false;
        } else {
            $view = new LoginView();

            $view->render();
        }
    }

    public function resetPassword() {
        if(!isset($_SESSION['leaderengine']['email_verified']) ||
           $_SESSION['leaderengine']['email_verified'] === false) {
            return false;
        }

        if($this->getRequestMethod() === 'POST') {
            $postData = $this->getPostData();

            $email = $postData['email'];
            $password = $postData['password'];

            $user = $this->userDao->getByEmail($email);

            if($user) {
                $user->setPassword($password);

                $this->userDao->update($user);

                header('Content-type: application/json');

                echo json_encode(['success' => true]);

                return true;
            }
        }
    }

    public function login() {
        
    }
}