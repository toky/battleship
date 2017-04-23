<?php
session_start();

// Set display erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
