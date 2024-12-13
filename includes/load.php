<?php
// -----------------------------------------------------------------------
// DEFINE SEPARATOR ALIASES
// -----------------------------------------------------------------------
define("URL_SEPARATOR", '/');
define("DS", DIRECTORY_SEPARATOR);

// -----------------------------------------------------------------------
// DEFINE ROOT PATHS
// -----------------------------------------------------------------------
defined('SITE_ROOT') ? null : define('SITE_ROOT', realpath(dirname(__FILE__)));
define("LIB_PATH_INC", SITE_ROOT.DS);

require_once(LIB_PATH_INC.'config.php');
require_once(LIB_PATH_INC.'functions.php');
require_once(LIB_PATH_INC.'session.php');
require_once(LIB_PATH_INC.'upload.php');
require_once(LIB_PATH_INC.'database.php');
require_once(LIB_PATH_INC.'sql.php');

// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Safely get user_id from session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$remote_ip = $_SERVER['REMOTE_ADDR'];
$action = $_SERVER['REQUEST_URI'];
$action = preg_replace('/^.+[\\\\\\/]/', '', $action);

// Logging disabled ~ remove the comment "//" to enable
 if ($user_id !== null) {
    logAction($user_id, $remote_ip, $action);
 }

?>
