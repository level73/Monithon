<?php
/** Set Debug Mode **/
define('DEBUG', true);
/** System status - influences error reporting **/
define('SYSTEM_STATUS', 'development');

/** Define Entities **/

/** Set default controller and route **/
define('DEFAULT_CONTROLLER', 'main');
define('DEFAULT_METHOD', 'index');

/** Paths **/
define('DIR_REPO', $_SERVER['DOCUMENT_ROOT'] . '/public/resources/' );
define('URL_REPO', '/public/resources/');

/** Permissions **/
define('P_CREATE_USER', 1);
define('P_ASSIGN_PERMISSIONS', 2);
define('P_CREATE_REPORT', 3);
define('P_ASSIGN_REPORT', 4);
define('P_EDIT_REPORT', 5);
define('P_COMMENT_REPORT', 6);
define('P_APPROVE_REPORT', 7);
define('P_BOUNCE_REPORT', 8);
define('P_MANAGE_REPORT_CARD', 9);
