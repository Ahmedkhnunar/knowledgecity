<?php

error_reporting(0);
ini_set('display_errors', 0);
ini_set('memory_limit', '-1');

// Database Settings
define("cDatabaseHost", "localhost");
define("cDatabaseUser", "root");
define("cDatabasePassword","");
define("cDatabase", "knowledgecity");

define("cRecordsPerPage", 5);

// 30 days for session
define("cSessionTime", 2678400);
define("cSessionName", "userSession");
define("cCookieName", "userCookie");


?>