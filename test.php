<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once './Wiki/idiorm-master/idiorm.php';
require_once './Wiki/paris-master/paris.php';


ORM::configure('mysql:host=localhost;dbname=documents');
ORM::configure('username', 'app');
ORM::configure('password', 'BamBoozale');

class Document extends Model
{
    public static $_table = 'documents';          // call method for initialisation table
    public static $_id_column = 'id';          // call method for initialisation table

}
$doc = Model::factory('Document')
    ->find_many();
echo '<pre>';

$htmlJson = base64_encode('stuff');
echo $htmlJson;
echo 'test';