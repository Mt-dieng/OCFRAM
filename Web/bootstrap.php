<?php
// var_dump(is_dir("C:\wamp64\www\OCFram"));
// var_dump(file_exists("C:\wamp64\www\OCFram\lib\OCFram\Page.php"));
// echo getcwd();
// var_dump($_GET['app']);
const DEFAULT_APP = 'Frontend';
var_dump('test');
// Si l'application n'est pas valide, on va charger l'application par défaut qui se chargera de générer une erreur 404
if (!isset($_GET['app']) || !file_exists(__DIR__.'/../App/'.$_GET['app'])) $_GET['app'] = DEFAULT_APP;

// On commence par inclure la classe nous permettant d'enregistrer nos autoload
require __DIR__.'/../lib/OCFram/SplClassLoader.php';

// require "C:\wamp64\www\OCFram\SplClassLoader.php";
// On va ensuite enregistrer les autoloads correspondant à chaque vendor (OCFram, App, Model, etc.)
$OCFramLoader = new SplClassLoader('OCFram', __DIR__.'/../lib');
$OCFramLoader->register();

$appLoader = new SplClassLoader('App', __DIR__.'/..');
$appLoader->register();

$modelLoader = new SplClassLoader('Model', __DIR__.'/../lib/vendors');
$modelLoader->register();

$entityLoader = new SplClassLoader('Entity', __DIR__.'/../lib/vendors');
$entityLoader->register();

$formBuilderLoader = new SplClassLoader('FormBuilder', __DIR__.'/../lib/vendors');
$formBuilderLoader->register();


// Il ne nous suffit plus qu'à déduire le nom de la classe et de l'instancier
$appClass = 'App\\'.$_GET['app'].'\\'.$_GET['app'].'Application';

$app = new $appClass;
$app->run();