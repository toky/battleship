<?php
//session_start();

//Define const for host, directory separator and home directory
define ('HOST',	'');
define ('DS', DIRECTORY_SEPARATOR);
define ('HOME', dirname(__FILE__));

// Degine main grid dimensions GridRow and GridCol
define ('GridRow', 10);
define ('GridCol', 10);

// Degine ships size
define ('BattleshipSize' , 5);
define ('DestroyerSize' , 4);
define ('Battleships', 1);
define ('Destroyers', 2);

define('IsClient', php_sapi_name() == 'cli');
define('Debug', true);


