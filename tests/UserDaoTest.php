<?php
use Models\User;
use Daos\UserDao;

class UserDaoTest {
    private $userDao = null;

    public function __construct() {
        $this->userDao = new UserDao(new Database(Config::getDbConfig()));

        echo 'Testing insert()<br />';

        $this->testInsert();

        echo '<br />Testing getById()<br />';

        $this->testGetById();

        echo '<br />Testing getByEmail()<br />';

        $this->testGetByEmail();

        echo '<br />Testing update()<br />';

        $this->testUpdate();

        echo '<br />Testing delete()<br />';

        $this->testDelete();
    }

    public function testInsert() {
        $user = new User(null, 'saubrent@amazon.com', 'brent123', null, 'Brenton Saunders', false, '704312', date('Y-m-d H:i:s', strtotime('+15 minutes')));

        $this->userDao->insert($user);
    }

    public function testGetById() {
        $user = $this->userDao->getById(1);

        echo '<pre>';

        print_r($user);

        echo '</pre>';
    }

    public function testGetByEmail() {
        $user = $this->userDao->getByEmail('saubrent@amazon.com');

        echo '<pre>';

        print_r($user);

        echo '</pre>';
    }

    public function testUpdate() {
        $user = $this->userDao->getByEmail('saubrent@amazon.com');

        $user->setName('Drew Saunders');

        $this->userDao->update($user);

        $user = $this->userDao->getByEmail('saubrent@amazon.com');

        echo '<pre>';

        print_r($user);

        echo '</pre>';
    }

    public function testDelete() {
        $user = $this->userDao->getByEmail('saubrent@amazon.com');

        $this->userDao->delete($user);
    }
}