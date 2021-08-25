<?php
session_start();
date_default_timezone_set("America/New_York");
require_once(__DIR__ . '/functions.php');
require_once(__DIR__ . '/mysql.php');

require_once(__DIR__ . '/../client_info/data_report.php');

require_once(__DIR__ . '/navigate_home.php');

require_once(__DIR__ . '/recaptcha_config.php');