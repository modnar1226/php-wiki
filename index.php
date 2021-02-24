<?php
require 'Wiki/autoloader.php';
use Wiki\Main;

    $wiki = new Main();
if (empty($_POST)) {
    $wiki->index();
} else {
    echo $wiki->getDoc($_POST['document']);
}