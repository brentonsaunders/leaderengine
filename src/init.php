<?php
require 'autoload.php';
require '../config/Config.php';

date_default_timezone_set('US/Eastern');

session_start();

if(!isset($_SESSION['leaderengine'])) {
    $_SESSION['leaderengine'] = [];
}