<?php
error_reporting(E_ALL);
ini_set('display_errors', true);
require_once 'vendor/autoload.php';

$fileInclude = !empty($_POST) ? '/resultado.php' : '/formulario.php'; 
include(__DIR__.$fileInclude);