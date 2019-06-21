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

	/** Application base URL **/
	define('APPURL', 'http://yourdomain.tld');

	/** **/
