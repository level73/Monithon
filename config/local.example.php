<?php
	/** Application Name **/
	define( 'APPNAME',  'ApplicationName');
	define( 'APPKEY',   'should be a random string');  // should be a random string

	/** Secret! **/
	define( 'SECRET',   strrev(md5(APPKEY)));

	/** Database connection params **/
    define('DBTYPE', 'mysql');
    define('DBUSER', 'dbuser');
    define('DBPASS', 'dbpassword');
    define('DBNAME', 'dbname');
    define('DBHOST', 'localhost');

	/** session keys **/
	define('SESSIONKEY',  md5(APPKEY));
	define('SESSIONNAME', md5(APPKEY . SESSIONKEY));
	define('SESSIONSALT', strrev(SESSIONKEY));

	/** Application email account **/
	define('APPEMAIL', 'the_app@email');
    define('APPEMAIL_NAME', 'Email Name');
    define('APPEMAIL_PWD', '');

    /** Application base URL **/
	define('APPURL', 'http://yourdomain.tld');
    define('ISO2', 'it');
    // Currency ISO 4217 Code
    define('CURRENCY_STR', 'EUR');

	/** LANGUAGES **/
	define('PRIMARY_LANG', 'it');
