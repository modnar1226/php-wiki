# php-wiki

[![Author](http://img.shields.io/badge/author-@modnar1226-blue.svg?style=flat-square)](https://example.com)

A configurebale php wiki tool.


# Usage Example:
``` php
<?php
require 'Wiki/autoloader.php';
use Main;

$wiki = new Main();
if (empty($_POST)) {
    $wiki->index();
} else {
    echo $wiki->getDoc($_POST['document']);
}
```

# Config Example:
```php
<?php
/**
 * Add 3rd party dependancies here. Usefull for when you have either compiled css and javascript or using individual files specific to the documentation
 * Css and Js are loaded in order of the array indices 
 */
return [
    'use_database' => true,
    'db_host' => 'mysql:host=localhost;dbname=documents',
    'db_username' => 'your-database-username',
    'db_password' => 'your-secret-password',  
];
```

## Features

* **Css and Javascript Not Required**: Examples loaded with a bootstrap theme to generate an html page with styling.
* **Database or File System Storage**: Uses either global constants or configuration file to connect to mysql database

## Planned features:

1. Html text editor, allowing direct editing capabilities to either file based or database hosted documents.
2. Pdf export of documents.
