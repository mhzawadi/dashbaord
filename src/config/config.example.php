<?php
/**
 *	BASE definition if Site
 * 	is not in root directory (e.g. /site/)
 *
 *  Also change
 *	RewriteBase / in .htaccess
 ******************************/
define('BASE', "/");
$settings['inactivityTimeout'] = 3600;

/*	database connection details
 *****************************
 * please see the database.php file
 */
DB::config('config/database.php');
