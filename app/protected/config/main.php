<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'API - Transparência JP',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
		'application.extensions.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '1234',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1','10.4.0.99','192.168.56.1', '::1'),
        ),
    ),
	
    // application components
    'components' => array(
		'cache' => array(
        		'class' => 'CFileCache',
    		),
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                array('api/listar', 'pattern' => 'api/<model:\w+>', 'verb' => 'GET'),
                array('api/detalhe', 'pattern' => 'api/<model:\w+>/detalhe', 'verb' => 'GET'),
                array('api/total', 'pattern' => 'api/<model:\w+>/total', 'verb' => 'GET'),
			   array('api/filtro', 'pattern' => 'api/<model:\w+>/filtro', 'verb' => 'GET'),
				array('api/orgaos', 'pattern' => 'api/<model:\w+>/orgaos', 'verb' => 'GET'),
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        'db' => array(
            'connectionString' => 'pgsql:host=localhost;dbname=lei131',
            'emulatePrepare' => true,
            //'username' => 'lei131',
            //'password' => 'avUNKFhaaouKpr',
            'username' => 'app',
            'password' => 'LFJVs3xFBEeep53C',
            'charset' => 'utf8',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
    ),
);

//$sicoda_db_user = "lei131";
//$sicoda_db_pass = "avUNKFhaaouKpr";