<?php
class Config {
    static function getDbConfig() {
        return [
            'host' => 'localhost',
            'dbname' => 'leaderengine3',
            'user' => 'root',
            'password' => ''
        ];
    }

    static function getTemplateDir() {
        return 'C:\\xampp\\htdocs\\leaderengine3\\templates';
    }
}